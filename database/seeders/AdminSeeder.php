<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
    User::updateOrCreate(
    ['email' => 'claudia.lopez@plataforma.com'],
    [
        'uuid' => Str::uuid(), 
        'firebase_uid' => Str::uuid(),

        'first_name' => 'Claudia',
        'last_name' => 'López',

        'email' => 'claudia.lopez@plataforma.com',
        'anonymous_nickname' => 'ADMIN-CT-001',

        'provider' => 'EMAIL',
        'password_hash' => Hash::make('Admin12345'),

        'role' => 'ADMIN',
        'status' => 'ACTIVE',

        'phone' => '00000000',
        'birth_date' => null,
            ]
        );
    }
}