<?php

namespace App\Ai\Agents;

use App\Ai\Tools\GetServicesInfoTool;
use App\Ai\Tools\SaveLeadTool;
use App\Models\BillingServicesMaster;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class ChatAgent implements Agent, Conversational, HasTools
{
    use Promptable;

    public function __construct(private array $history = []) {}

    public function instructions(): Stringable|string
    {
        $servicesSnapshot = $this->buildServicesSnapshot();

        return <<<PROMPT
            You are the Vibes Beauty & Wellness Assistant — a warm, knowledgeable beauty advisor chatbot for Vibes Slimming, Beauty & Laser clinics (India's most trusted wellness chain since 2005, 32 clinics, 2M+ happy clients).

            SERVICES KNOWLEDGE BASE:
            {$servicesSnapshot}

            BEHAVIOR:
            1. Be warm, friendly, and helpful. Use a conversational tone suited to a beauty & wellness brand.
            2. Answer questions about treatments, pricing, categories, and offers using the knowledge base above.
            3. If a visitor asks about something not in the snapshot, use the get_services_info tool to fetch live data.
            4. For questions like "what offers are available this month?", "offers in May?", "April deals?" — use get_services_info with type="offers_by_month" and keyword=month name.
            5. For "what offers are on right now?" — use get_services_info with type="active_offers".
            6. When the tool returns data in markdown table format (lines starting with |), present it AS-IS to the user — do NOT rewrite it as bullet points, prose, or inline text. Copy the table exactly.
            7. When listing multiple services, offers, or comparisons — always use markdown table format. Never use inline pipe characters in a sentence.
            8. Gently guide interested visitors to book a session by collecting their details.
            9. Collect: Name, Email, Phone Number, City, and Treatment of Interest — one or two at a time, conversationally.
            10. Once you have all FIVE details, call the save_lead tool. The "project" field should be the treatment/interest they mentioned.
            11. After saving, thank them and let them know a Vibes specialist will reach out within 24 hours.
            12. Never ask for information already provided in the conversation history.
            13. Keep responses concise and friendly (2–3 sentences max unless showing a table).
            PROMPT;
    }

    /**
     * Build a compact snapshot of active services grouped by category
     * to inject directly into the system prompt.
     */
    private function buildServicesSnapshot(): string
    {
        try {
            $services = BillingServicesMaster::where('status', 'Active')
                ->orderBy('category')
                ->orderBy('sub_category')
                ->get();

            if ($services->isEmpty()) {
                return 'No services currently available.';
            }

            $grouped = $services->groupBy('category');
            $lines   = [];

            foreach ($grouped as $category => $items) {
                $lines[] = "\n[{$category}]";
                foreach ($items as $s) {
                    $price = $s->min_price
                        ? "₹{$s->min_price}–₹{$s->max_price}"
                        : "₹{$s->max_price}";
                    $offer = '';
                    if ($s->offer_amount && $s->offer_s_date && $s->offer_e_date) {
                        $offer = " | 🏷️ OFFER: ₹{$s->offer_amount}"
                               . " ({$s->offer_s_date->format('d M')}–{$s->offer_e_date->format('d M Y')})";
                    }
                    $lines[] = "  • {$s->service_name} ({$s->sub_category}) | {$price}{$offer} per {$s->unit}";
                }
            }

            // Append active offers summary
            $today   = \Illuminate\Support\Carbon::today();
            $offers  = BillingServicesMaster::where('status', 'Active')
                ->whereNotNull('offer_amount')
                ->where('offer_s_date', '<=', $today)
                ->where('offer_e_date', '>=', $today)
                ->get();

            if ($offers->isNotEmpty()) {
                $lines[] = "\n[CURRENT MONTH OFFERS — valid till " . $offers->first()->offer_e_date->format('d M Y') . "]";
                foreach ($offers as $s) {
                    $saving  = $s->max_price - $s->offer_amount;
                    $lines[] = "  • {$s->service_name} | Regular: ₹{$s->max_price} → Offer: ₹{$s->offer_amount} (Save ₹{$saving})";
                }
            }

            return implode("\n", $lines);
        } catch (\Throwable) {
            return 'Service details temporarily unavailable.';
        }
    }

    /**
     * @return Message[]
     */
    public function messages(): iterable
    {
        return array_map(
            fn($msg) => new Message($msg['role'], $msg['content']),
            $this->history
        );
    }

    /**
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new GetServicesInfoTool,
            new SaveLeadTool,
        ];
    }
}
