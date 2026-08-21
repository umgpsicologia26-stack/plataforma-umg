<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;

class MaintenanceMode
{
    //Handle an incoming request.
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $settings = SystemSetting::first();

        //Si mantenimiento está desactivado
            if (
            !$settings ||
            !$settings->maintenance_mode
        ) 
        
        {
            return $next($request);
        }

        //El administrador puede continuar
        
        if (
            Auth::check() &&
            Auth::user()->role === 'ADMIN'
        ) 
        
        {
            return $next($request);
        }

        //Mostrar pantalla de mantenimiento
        return response()->view('maintenance');
    }
}