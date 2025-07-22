<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@vitalait.tn'],
            [
                'name' => 'Super Admin',
                'role' => 'superadmin',
                'is_approved' => true,
                'password' => Hash::make('vitalait123'),
            ]
        );
    }
}
