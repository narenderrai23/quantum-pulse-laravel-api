<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email    = env('ADMIN_EMAIL', 'admin@gmail.com');
        $name     = env('ADMIN_NAME', 'Admin');
        $password = env('ADMIN_PASSWORD', 'admin');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name'     => $name,
                'password' => Hash::make($password),
                'role'     => 'admin',
            ]
        );

        $this->command->info("Admin user ready: {$user->email}");
    }
}
