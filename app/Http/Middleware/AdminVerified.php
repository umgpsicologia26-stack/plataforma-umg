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
                    'No tienes permisos para acceder al área administrativa.'
                );
        }

        if (
            !session('admin_verified') ||
            session('admin_verified_user') !== Auth::user()->uuid
        ) {
            return redirect('/admin-access')
                ->with(
                    'error',
                    'Debes verificar la contraseña de administrador.'
                );
        }

        return $next($request);
    }
}