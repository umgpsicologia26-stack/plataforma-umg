<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Agrega encabezados HTTP de seguridad a las respuestas.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Oculta información sobre el servidor PHP.
        $response->headers->remove('X-Powered-By');

        // Evita que el navegador interprete archivos con un tipo MIME incorrecto.
        $response->headers->set(
            'X-Content-Type-Options',
            'nosniff'
        );

        // Evita que la aplicación pueda ser cargada dentro de un iframe
        // desde otro origen.
        $response->headers->set(
            'X-Frame-Options',
            'SAMEORIGIN'
        );

        // Controla qué información de referencia envía el navegador.
        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );

        // Restringe funciones del navegador que la aplicación no necesita.
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=()'
        );

        // HSTS solamente cuando la aplicación funciona mediante HTTPS.
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        // Política de seguridad de contenido en modo Report-Only.
        // No bloquea recursos; solamente permite detectar posibles incompatibilidades.
        $response->headers->set(
            'Content-Security-Policy-Report-Only',
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' https://www.gstatic.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; " .
            "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; " .
            "img-src 'self' data: https://images.unsplash.com https://*.googleusercontent.com; " .
            "connect-src 'self' https://identitytoolkit.googleapis.com https://securetoken.googleapis.com https://www.googleapis.com; " .
            "frame-src 'self' https://*.firebaseapp.com; " .
            "object-src 'none'; " .
            "base-uri 'self'; " .
            "form-action 'self';"
        );

        return $response;
    }
}