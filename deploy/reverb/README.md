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
