# Integración candidata de Laravel Reverb

**Estado: rama de integración; no desplegar en producción.**

Esta rama parte de `main` y conserva sus cambios previos. Solo prepara una
integración candidata para ejecutar Reverb en el mismo Web Service que Apache.
No se modifican variables de DigitalOcean ni el Run Command de producción.

## Diseño

- Apache continúa atendiendo el puerto público actual.
- Reverb escucha internamente en `127.0.0.1:6001`.
- Apache reenvía `/apps` por HTTP y `/app` por WebSocket.
- El navegador se conecta al dominio HTTPS/WSS; el puerto 6001 no se expone.
- El lanzador espera que Reverb acepte conexiones antes de iniciar Apache.
- Si Reverb o el proceso Apache/PHP-FPM termina, el lanzador detiene el otro.

## Archivos

- `start-with-reverb.sh`: lanzador supervisado; usa el comando
  `heroku-php-apache2` encontrado en PATH, igual que el Run Command actual.
- `apache-reverb.conf`: reglas de proxy para HTTP y WebSocket.
- `resources/js/echo.js`: autenticación de canales privados mediante
  `/broadcasting/auth`, CSRF y encabezado XMLHttpRequest.
- `config/reverb.php`: orígenes permitidos configurables mediante
  `REVERB_ALLOWED_ORIGINS`.

## Variables que se deben validar en un entorno aislado

Servidor interno:
- `REVERB_SERVER_HOST=127.0.0.1`
- `REVERB_SERVER_PORT=6001`

Publicación de eventos desde Laravel (destino interno):
- `BROADCAST_CONNECTION=reverb`
- `REVERB_HOST=127.0.0.1`
- `REVERB_PORT=6001`
- `REVERB_SCHEME=http`

Conexión del navegador (valores incorporados durante Vite build):
- `VITE_REVERB_HOST=vitasafe.org` (solo hostname, sin protocolo)
- `VITE_REVERB_PORT=443`
- `VITE_REVERB_SCHEME=https`
- `VITE_REVERB_APP_KEY` debe coincidir con `REVERB_APP_KEY`.

No colocar secretos en variables `VITE_*`. Cambiar valores Vite requiere
reconstruir los recursos frontend.

## Validaciones pendientes antes de producción

1. Confirmar en el contenedor real que Bash, `heroku-php-apache2`,
   `mod_proxy` y el soporte WebSocket están disponibles.
2. Ejecutar `bash -n deploy/reverb/start-with-reverb.sh`.
3. Confirmar que el arranque supervisado funciona con Reverb real y Apache/PHP-FPM.
4. Probar desde una URL HTTPS de ensayo el handshake WSS, intercambio de tramas,
   autenticación de canales privados y emisión/recepción de eventos.
5. Verificar que el entorno de App Platform admite Upgrade WebSocket en esta
   configuración.
6. Medir memoria, CPU, reconexiones y comportamiento de las peticiones HTTP.
7. Configurar `REVERB_ALLOWED_ORIGINS` únicamente con los hosts autorizados.
8. Revisar la disponibilidad de `ext-pcntl` y las dependencias Composer
   efectivamente instaladas en el contenedor. Esta rama no agrega requisitos
   Composer sin verificar primero el runtime.

Las pruebas locales previas de la rama experimental validaron sintaxis de
Apache, proxy HTTP y handshake WebSocket con un backend simulado. No equivalen
a una prueba integrada de Laravel Reverb ni de DigitalOcean App Platform.

## Seguridad y límites

- `config/reverb.php` deja de aceptar cualquier origen por defecto.
- El valor predeterminado de orígenes es `vitasafe.org`; se puede sustituir
  mediante `REVERB_ALLOWED_ORIGINS` con una lista separada por comas.
- No reutilizar la base de datos, credenciales ni datos de usuarios de producción
  para pruebas.
- No cambiar el Run Command, variables, autodeploy ni configuración de producción
  desde esta rama.
- Esta rama no se debe fusionar hasta aprobar todas las validaciones anteriores.
