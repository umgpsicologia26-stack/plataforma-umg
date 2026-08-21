<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MustChangePassword
{
    //Handle an incoming request.
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        //Verificar usuario autenticado
                if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        //Permitir acceder al cambio de contraseña
                if ($request->is('change-password')) {
            return $next($request);
        }

        //Verificar si debe cambiar la contraseña
                if ($user->must_change_password) {

            return redirect()
                ->route('password.change')
                ->with(
                    'warning',
                    'Debes cambiar tu contraseña antes de continuar.'
                );
        }

        return $next($request);
    }
}