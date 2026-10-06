<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== 'ADMIN') {
            return redirect('/dashboard')
                ->with(
                    'error',
                    'No tienes permisos para acceder a esta sección.'
                );
        }

        $verifiedAt = session('admin_verified_at');
        $verifiedUser = session('admin_verified_user');

        /*
         * La verificación administrativa debe existir,
         * pertenecer al administrador actual y no haber
         * superado 15 minutos de INACTIVIDAD.
         */
        if (
            !session('admin_verified') ||
            $verifiedUser !== Auth::user()->uuid ||
            !$verifiedAt ||
            now()->timestamp - $verifiedAt > 900
        ) {
            session()->forget([
                'admin_verified',
                'admin_verified_user',
                'admin_verified_at',
            ]);

            return redirect('/admin-access')
                ->with(
                    'error',
                    'La verificación administrativa expiró por inactividad. Debes verificar nuevamente tu contraseña.'
                );
        }

        /*
         * Hubo actividad dentro del área administrativa.
         * Renovar los 15 minutos.
         */
        session([
            'admin_verified_at' => now()->timestamp,
        ]);

        return $next($request);
    }
}