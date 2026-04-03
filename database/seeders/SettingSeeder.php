<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('gemini_api_key', env('GEMINI_API_KEY', ''));
        Setting::set('next_public_api_url', env('APP_URL', ''));
        Setting::set('site_name', 'Quantum Digital');
        Setting::set('logo_url', '');
        Setting::set('favicon_url', '');
    }
}
