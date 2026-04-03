<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $leads = [
            [
                'lead_id'    => 'seed-1',
                'name'       => 'Jane Smith',
                'email'      => 'jane@example.com',
                'phone'      => '+1 555-010-9988',
                'city'       => 'San Francisco',
                'project'    => 'Looking for a futuristic 3D portfolio site.',
                'status'     => 'new',
                'created_at' => '2024-10-25 10:00:00',
            ],
        ];

        foreach ($leads as $lead) {
            Lead::firstOrCreate(['lead_id' => $lead['lead_id']], $lead);
        }
    }
}
