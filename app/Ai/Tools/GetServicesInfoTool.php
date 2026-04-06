<?php

namespace App\Ai\Tools;

use App\Models\BillingServicesMaster;
use App\Models\BillingOffersServices;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Illuminate\Support\Carbon;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class GetServicesInfoTool implements Tool
{
    public function description(): Stringable|string
    {
        return 'Fetch service, offer, or pricing information. Supports: "services", "offers", "categories", "active_offers", "offers_by_month".';
    }

    public function handle(Request $request): Stringable|string
    {
        $type    = $request->string('type');
        $keyword = $request->string('keyword');  // optional search / month name e.g. "April" or "2026-04"

        return match ($type) {
            'categories'     => $this->getCategories(),
            'offers'         => $this->getOffers($keyword),
            'active_offers'  => $this->getActiveOffers(),
            'offers_by_month'=> $this->getOffersByMonth($keyword),
            default          => $this->getServices($keyword),
        };
    }

    // ── Categories ────────────────────────────────────────────────────────────
    private function getCategories(): string
    {
        $categories = BillingServicesMaster::select('category', 'sub_category')
            ->distinct()->orderBy('category')->get()
            ->groupBy('category')
            ->map(fn($rows) => $rows->pluck('sub_category')->unique()->filter()->values())
            ->toArray();

        $result = "Available treatment categories:\n";
        foreach ($categories as $cat => $subs) {
            $result .= "- {$cat}: " . implode(', ', $subs) . "\n";
        }
        return $result;
    }

    // ── Offer groups (billing_offers_services) ────────────────────────────────
    private function getOffers(string $keyword): string
    {
        $query = BillingOffersServices::with('service');
        if ($keyword) {
            $query->where('service_name', 'like', "%{$keyword}%");
        }
        $offers = $query->get()->groupBy('offer_id');

        if ($offers->isEmpty()) {
            return 'No offers found' . ($keyword ? " matching \"{$keyword}\"." : '.');
        }

        $result = "**Offer Packages**\n\n";
        foreach ($offers as $offerId => $lines) {
            $result .= "**Offer #{$offerId}**\n\n"
                     . "| Service | Qty | Offer Price | Valid |\n"
                     . "|---|---|---|---|\n";
            foreach ($lines as $line) {
                $s        = $line->service;
                $offer    = $s && $s->offer_amount ? "₹{$s->offer_amount}" : '—';
                $validity = ($s && $s->offer_s_date && $s->offer_e_date)
                    ? $s->offer_s_date->format('d M Y') . ' – ' . $s->offer_e_date->format('d M Y')
                    : '—';
                $result .= "| {$line->service_name} | {$line->qty} | {$offer} | {$validity} |\n";
            }
            $result .= "\n";
        }
        return $result;
    }

    // ── Currently active offers (today falls within offer window) ─────────────
    private function getActiveOffers(): string
    {
        $today    = Carbon::today();
        $services = BillingServicesMaster::where('status', 'Active')
            ->whereNotNull('offer_amount')
            ->whereNotNull('offer_s_date')
            ->whereNotNull('offer_e_date')
            ->where('offer_s_date', '<=', $today)
            ->where('offer_e_date', '>=', $today)
            ->orderBy('category')
            ->get();

        if ($services->isEmpty()) {
            return 'No active offers available right now.';
        }

        $result = "**Active Offers — Today {$today->format('d M Y')}**\n\n"
                . "| Service | Category | Regular | Offer Price | You Save | Valid Till |\n"
                . "|---|---|---|---|---|---|\n";

        foreach ($services as $s) {
            $saving  = $s->max_price - $s->offer_amount;
            $result .= "| {$s->service_name} | {$s->category} | ₹{$s->max_price} | ₹{$s->offer_amount} | ₹{$saving} | {$s->offer_e_date->format('d M Y')} |\n";
        }
        return $result;
    }

    // ── Offers filtered by month ───────────────────────────────────────────────
    private function getOffersByMonth(string $keyword): string
    {
        $month = null;
        $year  = null;

        if (preg_match('/(\d{4})-(\d{2})/', $keyword, $m)) {
            $year  = (int) $m[1];
            $month = (int) $m[2];
        } elseif (is_numeric($keyword) && $keyword >= 1 && $keyword <= 12) {
            $month = (int) $keyword;
            $year  = Carbon::now()->year;
        } else {
            try {
                $parsed = Carbon::parse("1 {$keyword} " . Carbon::now()->year);
                $month  = $parsed->month;
                $year   = $parsed->year;
            } catch (\Throwable) {
                return "Could not understand the month \"{$keyword}\". Please use a month name like \"April\" or format like \"2026-04\".";
            }
        }

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        $services = BillingServicesMaster::where('status', 'Active')
            ->whereNotNull('offer_amount')
            ->where('offer_s_date', '<=', $end)
            ->where('offer_e_date', '>=', $start)
            ->orderBy('category')
            ->get();

        if ($services->isEmpty()) {
            return "No offers found for {$start->format('F Y')}.";
        }

        $result = "**Offers in {$start->format('F Y')}**\n\n"
                . "| Service | Category | Regular | Offer Price | You Save | Offer Period |\n"
                . "|---|---|---|---|---|---|\n";

        foreach ($services as $s) {
            $saving = $s->max_price - $s->offer_amount;
            $period = $s->offer_s_date->format('d M') . ' – ' . $s->offer_e_date->format('d M Y');
            $result .= "| {$s->service_name} | {$s->category} | ₹{$s->max_price} | ₹{$s->offer_amount} | ₹{$saving} | {$period} |\n";
        }
        return $result;
    }

    // ── Services list ─────────────────────────────────────────────────────────
    private function getServices(string $keyword): string
    {
        $query = BillingServicesMaster::where('status', 'Active');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('service_name', 'like', "%{$keyword}%")
                  ->orWhere('category', 'like', "%{$keyword}%")
                  ->orWhere('sub_category', 'like', "%{$keyword}%");
            });
        }

        $services = $query->orderBy('category')->orderBy('sub_category')->get();

        if ($services->isEmpty()) {
            return 'No services found' . ($keyword ? " matching \"{$keyword}\"." : '.');
        }

        $title = "Services" . ($keyword ? " matching \"{$keyword}\"" : '');

        // Single result — plain text
        if ($services->count() === 1) {
            $s         = $services->first();
            $price     = $s->min_price ? "₹{$s->min_price}–₹{$s->max_price}" : "₹{$s->max_price}";
            $offerInfo = $this->offerLine($s);
            return "{$title}:\n- {$s->service_name} | {$s->category} > {$s->sub_category} | {$price}{$offerInfo} | per {$s->unit}";
        }

        // Multiple results — markdown table
        $rows = "**{$title}**\n\n"
              . "| Service | Category | Regular Price | Offer Price | Offer Valid | Unit |\n"
              . "|---|---|---|---|---|---|\n";

        foreach ($services as $s) {
            $price     = $s->min_price ? "₹{$s->min_price}–₹{$s->max_price}" : "₹{$s->max_price}";
            $offer     = $s->offer_amount ? "₹{$s->offer_amount}" : '—';
            $validity  = ($s->offer_s_date && $s->offer_e_date)
                ? $s->offer_s_date->format('d M') . ' – ' . $s->offer_e_date->format('d M Y')
                : '—';
            $rows .= "| {$s->service_name} | {$s->category} | {$price} | {$offer} | {$validity} | {$s->unit} |\n";
        }
        return $rows;
    }

    // ── Shared helper ─────────────────────────────────────────────────────────
    private function offerLine($s): string
    {
        if (!$s || !$s->offer_amount) return '';
        $saving = $s->max_price - $s->offer_amount;
        $dates  = ($s->offer_s_date && $s->offer_e_date)
            ? " | Valid: {$s->offer_s_date->format('d M Y')} – {$s->offer_e_date->format('d M Y')}"
            : '';
        return " | 🏷️ Offer: ₹{$s->offer_amount} (Save ₹{$saving}){$dates}";
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'type'    => $schema->string('What to fetch: "services", "offers", "categories", "active_offers", or "offers_by_month"'),
            'keyword' => $schema->string('Optional: search keyword for services/offers, or month name/number for offers_by_month (e.g. "April", "2026-05")'),
        ];
    }
}
