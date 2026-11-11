<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'umgpsicologia26@gmail.com';

        $admin = User::withTrashed()
            ->where('email', $email)
            ->first();

        if ($admin && $admin->trashed()) {
            throw new RuntimeException(
                'La cuenta existe eliminada lógicamente. Debe revisarse antes de recuperarla.'
            );
        }

        if ($admin && $admin->role !== 'ADMIN') {
            throw new RuntimeException(
                'El correo ya pertenece a una cuenta que no es ADMIN.'
            );
        }

        // Si el administrador ya existe, no cambiar su contraseña,
        // UUID, rol, estado ni configuración de autenticación.
        if ($admin) {
            $this->command?->info(
                'El administrador ya existe. Se conservaron sus datos y credenciales.'
            );

            return;
        }

        // La contraseña solo se necesita para crear una cuenta nueva.
        $password = env('ADMIN_PASSWORD');

        if (!is_string($password) || strlen($password) < 12) {
            throw new RuntimeException(
                'ADMIN_PASSWORD debe estar configurada y tener al menos 12 caracteres.'
            );
        }

        $admin = new User();

        $admin->uuid = (string) Str::uuid();
        $admin->email = $email;
        $admin->first_name = 'Administrador';
        $admin->last_name = 'UMG';
        $admin->anonymous_nickname = 'ADMIN-UMG-001';
        $admin->provider = 'EMAIL';
        $admin->password_hash = Hash::make($password);
        $admin->role = 'ADMIN';
        $admin->status = 'Activo';
        $admin->must_change_password = false;
        $admin->google2fa_enabled = false;
        $admin->google2fa_secret = null;

        $admin->save();

        $this->command?->info(
            'Administrador creado. Debe completar la configuración de 2FA al iniciar sesión.'
        );
    }
}
