<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillingOffersServicesSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch service IDs by name for FK integrity
        $get = fn(string $name) => DB::table('billing_services_master')
            ->where('service_name', 'like', "%{$name}%")
            ->value('id');

        $records = [
            // Offer 1 — Salon Basic Package
            ['offer_id' => 1, 'service_name' => 'Hair Cut',               'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Hair Wash - Medium',     'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Glow Facial',            'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Pedicure',               'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Manicure',               'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Waxing - Half Legs',     'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Waxing - Half Arms',     'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Threading - Eyebrows',   'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Shave',                  'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Bleach - Face & Neck',   'record_date' => '2021-12-28 12:03:10'],
            ['offer_id' => 1, 'service_name' => 'Scalp Massage - Olive Oil', 'record_date' => '2021-12-28 12:03:10'],
            // Offer 2 — Salon Basic Package (repeat batch)
            ['offer_id' => 2, 'service_name' => 'Hair Cut',               'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Hair Wash - Medium',     'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Glow Facial',            'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Pedicure',               'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Manicure',               'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Waxing - Half Legs',     'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Waxing - Half Arms',     'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Threading - Eyebrows',   'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Shave',                  'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Bleach - Face & Neck',   'record_date' => '2021-12-28 12:46:36'],
            ['offer_id' => 2, 'service_name' => 'Scalp Massage - Olive Oil', 'record_date' => '2021-12-28 12:46:36'],
            // Offer 3 — Advanced Beauty Package
            ['offer_id' => 3, 'service_name' => 'GFC (Growth Factor Concentrate)', 'record_date' => '2021-12-28 12:51:25'],
            ['offer_id' => 3, 'service_name' => 'Hair Pro',               'record_date' => '2021-12-28 12:51:25'],
            ['offer_id' => 3, 'service_name' => 'Threads',                'record_date' => '2021-12-28 12:51:25'],
            ['offer_id' => 3, 'service_name' => 'CoolSculpting',          'record_date' => '2021-12-28 12:51:25'],
            ['offer_id' => 3, 'service_name' => 'VelaShape III',          'record_date' => '2021-12-28 12:51:25'],
        ];

        foreach ($records as $record) {
            $serviceId = $get($record['service_name']);
            if (!$serviceId) continue;

            DB::table('billing_offers_services')->insert([
                'offer_id'     => $record['offer_id'],
                'service_id'   => $serviceId,
                'service_name' => $record['service_name'],
                'qty'          => 1,
                'record_date'  => $record['record_date'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        $this->command->info('billing_offers_services seeded: ' . count($records) . ' records.');
    }
}
