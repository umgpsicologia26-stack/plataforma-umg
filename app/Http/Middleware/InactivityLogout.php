<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InactivityLogout
{
    private const TIMEOUT = 900; // 15 minutos

    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
         * Si no hay usuario autenticado,
         * no hay nada que controlar.
         */
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        /*
         * Obtener el último momento de actividad.
         */
        $lastActivity = session('last_activity');

        /*
         * Primera petición autenticada.
         */
        if (!$lastActivity) {

            session([
                'last_activity' => now()->timestamp
            ]);

            return $next($request);
        }

        /*
         * Comprobar si han pasado 15 minutos.
         */
        if (
            now()->timestamp - $lastActivity
            >= self::TIMEOUT
        ) {

            /*
             * ADMIN:
             * cerrar únicamente la verificación
             * administrativa.
             */
            if ($user->role === 'ADMIN') {

                session()->forget([
                    'admin_verified',
                    'admin_verified_user',
                    'admin_verified_at',
                    'last_activity',
                ]);

                return redirect('/admin-access')
                    ->with(
                        'error',
                        'La sesión administrativa expiró por inactividad. Debes verificar nuevamente tu contraseña.'
                    );
            }

            /*
             * MODERATOR y USER:
             * cerrar completamente la sesión.
             */
            Auth::logout();

            session()->invalidate();
            session()->regenerateToken();

            return redirect('/login')
                ->with(
                    'error',
                    'Tu sesión expiró por inactividad. Debes iniciar sesión nuevamente.'
                );
        }

        /*
         * Las peticiones AJAX automáticas no cuentan
         * como actividad del usuario.
         */
        if (!$request->ajax()) {

            session([
                'last_activity' => now()->timestamp
            ]);
        }

        return $next($request);
    }
}