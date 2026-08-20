<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
{
    $user = Auth::user();

    if (!$user) {
        return redirect('/login')
            ->with('error', 'Debes iniciar sesión para continuar.');
    }

    if (!in_array($user->role, $roles)) {
        return redirect('/dashboard')
            ->with('error', 'No tienes permisos para acceder a esta sección.');
    }

    return $next($request);
}
}