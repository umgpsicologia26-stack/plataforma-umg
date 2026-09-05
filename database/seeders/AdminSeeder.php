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
            ['email' => 'umgpsicologia26@gmail.com'],
            [
                'uuid' => (string) Str::uuid(),
                'firebase_uid' => (string) Str::uuid(),

                'first_name' => 'Administrador',
                'last_name' => 'UMG',

                'anonymous_nickname' => 'ADMIN-UMG-001',

                'provider' => 'EMAIL',
                'password_hash' => Hash::make(env('ADMIN_PASSWORD')),

                'role' => 'ADMIN',
                'status' => 'Activo',

                'phone' => null,
                'birth_date' => null,
            ]
        );
    }
}