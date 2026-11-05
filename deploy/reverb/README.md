# Prueba aislada: Laravel Reverb en el Web Service existente

**Estado: preparación; no habilitado en producción.**

Esta carpeta contiene una configuración candidata para evaluar Reverb dentro
del mismo contenedor que ejecuta Apache/PHP-FPM en DigitalOcean App Platform.
No se debe copiar ni activar en producción hasta completar las comprobaciones.

## Diseño que se quiere validar

- Apache conserva el puerto público actual `8080`.
- Reverb escucha internamente en `127.0.0.1:6001`.
- Apache reenvía `/apps` mediante HTTP y `/app` mediante WebSocket a Reverb.
- El navegador se conecta al dominio HTTPS existente, usando WSS por el puerto
  público 443. El puerto interno 6001 no se expone a Internet.
- La dirección de escucha interna (`REVERB_SERVER_HOST`,
  `REVERB_SERVER_PORT`) es distinta de la dirección pública del cliente
  (`REVERB_HOST`, `REVERB_PORT`, `REVERB_SCHEME`).

## Archivos candidatos

- `apache-reverb.conf`: reglas ProxyPass. `/apps` se declara antes de
  `/app` para evitar que la regla de prefijo `/app` capture también `/apps`.
- `start-with-reverb.sh`: lanzador experimental. Inicia Reverb en loopback,
  espera a que el puerto responda y después inicia el lanzador existente
  `heroku-php-apache2`. Usa Bash `wait -n` para detectar si cualquiera de
  los dos procesos termina y detener el otro. El lanzador de Heroku continúa
  administrando Apache y PHP-FPM internamente.

## Comprobaciones obligatorias antes de cualquier despliegue

1. Confirmar la versión de Apache y que el módulo proxy WebSocket está cargado.
2. Confirmar que `heroku-php-apache2` acepta una configuración adicional
   mediante `-C` (la consola del contenedor mostró esa opción).
3. Revisar el lanzador experimental con pruebas de señales, fallos de arranque,
   caída de Reverb y caída de Apache/PHP-FPM. La validación `bash -n` por sí
   sola no demuestra que el ciclo de vida funcione correctamente.
4. Confirmar que App Platform admite el Upgrade WebSocket en esta configuración
   concreta del servicio PHP/Apache.
5. Probar primero en un entorno no productivo. La rama de prueba no debe
   conectarse a producción ni cambiar el autodeploy de `main`.
6. Medir memoria, CPU, reconexiones, autenticación de canales privados y
   funcionamiento normal de las peticiones HTTP.

## Parámetros conceptuales (no configurar todavía)

Servidor Reverb dentro del contenedor:

- `REVERB_SERVER_HOST=127.0.0.1`
- `REVERB_SERVER_PORT=6001`

Dirección pública para clientes:

- `REVERB_HOST=vitasafe.org`
- `REVERB_PORT=443`
- `REVERB_SCHEME=https`

Las claves `REVERB_APP_ID`, `REVERB_APP_KEY` y `REVERB_APP_SECRET`
deben ser valores secretos configurados de forma segura; nunca deben
guardarse en este repositorio ni escribirse en documentación.

Los nombres `VITE_REVERB_*` se incorporan al JavaScript durante el build.
Cualquier cambio de esos valores requiere una compilación nueva; no se deben
copiar secretos al prefijo `VITE_`.

## Límite de esta prueba

Estos archivos no instalan servicios, no modifican dependencias, no cambian
variables de DigitalOcean y no despliegan nada. Son propuestas para revisión
técnica, no instrucciones para activar la configuración en producción.

## Validación preliminar del lanzador

En un entorno local aislado (sin conectar con DigitalOcean ni con la aplicación real)
se hicieron estas comprobaciones:

- `bash -n`: sintaxis válida.
- Simulación con procesos falsos: cuando el lanzador web termina con error,
  el wrapper detecta la salida y detiene el proceso Reverb simulado.
- Simulación de señal `SIGTERM`: el wrapper termina con código 143 y detiene
  el proceso Reverb simulado.

Estas pruebas validan la lógica básica del wrapper, no el funcionamiento real
de Laravel Reverb, Apache, PHP-FPM ni el soporte WebSocket de DigitalOcean.
La configuración sigue siendo experimental y no está aprobada para producción.

## Validación local de Apache y del sondeo de disponibilidad

En una configuración temporal local de Apache 2.4.68, sin tocar el servidor
DigitalOcean, se cargaron los módulos `mod_proxy`, `mod_proxy_http` y
`mod_proxy_wstunnel`, se incluyó el archivo candidato dentro de un
`VirtualHost` y `apache2 -t` devolvió `Syntax OK`.

También se comprobó el paso de argumentos del sondeo PHP usado por el wrapper:
`$argv[1]` recibe `127.0.0.1` y `$argv[2]` recibe `6001`, por lo que
esa comprobación no tiene el problema de índices que se había considerado.

Esto confirma la sintaxis de las reglas en Apache 2.4.68 y el uso de argumentos
PHP. No confirma todavía el proxy en ejecución, el handshake WebSocket real,
la compatibilidad del proxy frontal de App Platform ni el comportamiento
integrado con el proceso real de Reverb.

## Prueba local de proxy HTTP y handshake WebSocket

Se ejecutó Apache local en un puerto temporal, con un backend Python simulado
en loopback (no Laravel Reverb y no DigitalOcean). Resultados:

- `apache2 -t`: `Syntax OK`.
- Solicitud HTTP a `/apps`: llegó al backend y devolvió
  `HTTP_BACKEND_OK /apps`.
- Solicitud WebSocket a `/app`: Apache devolvió
  `HTTP/1.1 101 Switching Protocols` y el encabezado
  `Sec-WebSocket-Accept` esperado.

La prueba confirma que las reglas actuales de Apache pueden reenviar HTTP y
negociar el handshake WebSocket con un backend compatible. No probó el
intercambio posterior de tramas WebSocket, autenticación Pusher/Reverb,
Laravel Echo, conexiones privadas ni el proxy frontal de DigitalOcean.
Tampoco prueba que el entorno real de App Platform permita el mismo flujo.
