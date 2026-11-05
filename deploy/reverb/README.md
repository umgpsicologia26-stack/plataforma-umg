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

Destino interno para que Laravel publique eventos hacia Reverb:

- `REVERB_HOST=127.0.0.1`
- `REVERB_PORT=6001`
- `REVERB_SCHEME=http`

Dirección pública para el navegador (valores Vite incorporados al build):

- `VITE_REVERB_HOST=vitasafe.org`
- `VITE_REVERB_PORT=443`
- `VITE_REVERB_SCHEME=https`
- `VITE_REVERB_APP_KEY` debe coincidir con `REVERB_APP_KEY`

No se debe confundir el destino interno de publicación del backend con el
destino público del navegador. `config/broadcasting.php` utiliza
`REVERB_HOST/PORT/SCHEME`, mientras que `resources/js/echo.js` utiliza
`VITE_REVERB_HOST/PORT/SCHEME`.

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

## Auditoría de integración Laravel Echo y canales

Revisión estática de la rama de pruebas:

- `resources/js/app.js` importa `./bootstrap` y
  `resources/js/bootstrap.js` importa `./echo`: Echo sí se carga en el
  bundle principal.
- `bootstrap/app.php` registra `routes/channels.php` mediante
  `withRouting(channels: ...)`.
- Los canales privados `moderator.{uuid}`, `user.{uuid}`,
  `admin.{uuid}` y `admins` aplican comprobaciones de rol/UUID.
  El canal `forum` permite a cualquier usuario autenticado.
- `config/broadcasting.php` usa `BROADCAST_CONNECTION`; si no se define,
  el valor predeterminado es `null`. Por tanto, una prueba real debe
  establecerlo explícitamente como `reverb`.
- Echo toma sus valores del build mediante `VITE_REVERB_APP_KEY`,
  `VITE_REVERB_HOST`, `VITE_REVERB_PORT` y
  `VITE_REVERB_SCHEME`. Cambiar esos valores requiere reconstruir los
  recursos Vite. El host debe ser el nombre DNS, sin protocolo.
- El servidor Reverb usa `REVERB_SERVER_HOST` y
  `REVERB_SERVER_PORT`; el backend Laravel usa `REVERB_HOST`,
  `REVERB_PORT` y `REVERB_SCHEME` para publicar eventos.

### Observación de seguridad pendiente

`config/reverb.php` conserva `allowed_origins => ['*']`. Antes de producción
debe limitarse al dominio autorizado. No se cambió en esta rama porque esta
etapa es una auditoría y no una modificación de configuración funcional.

### Estado de la prueba integrada

La inspección estática confirma que el bundle carga Echo y que Laravel registra
los canales. No se puede declarar completada una prueba integrada de conexión,
autenticación ni emisión/recepción de eventos: la rama no está desplegada en
un entorno de ensayo y no se inició un servidor real de Reverb. Para probarlo
sin afectar producción hace falta un entorno de ensayo aislado con su propia
base de datos, credenciales de Reverb y URL HTTPS/WSS. No se deben reutilizar
las credenciales ni la base de datos productivas.


## Preparar una prueba local aislada (Windows/XAMPP)

Se agregó `.env.testing.example` con valores locales de demostración. No contiene
claves productivas ni apunta a DigitalOcean. Para usarlo desde la copia local:

1. En la raíz del proyecto, copia `deploy/reverb/.env.testing.example` como
   `.env.testing`. No reemplaces ni edites tu archivo `.env` habitual.
2. Crea el archivo vacío `database/database.reverb-testing.sqlite` (la plantilla ya usa la ruta relativa `database.reverb-testing.sqlite`, que Laravel resuelve dentro de la carpeta `database`).
3. En una terminal situada en la raíz del proyecto ejecuta:

   ```powershell
   php artisan key:generate --env=testing
   php artisan migrate --env=testing
   ```

   Revisa primero que las migraciones de esta rama sean compatibles con SQLite.
   Si alguna requiere funciones exclusivas de MySQL, detente; no cambies tu
   base habitual para hacerla pasar.
4. Compila los recursos usando el modo de prueba:

   ```powershell
   npm run build -- --mode testing
   ```

5. Abre dos terminales en la raíz del proyecto. En la primera inicia Reverb:

   ```powershell
   php artisan reverb:start --host=127.0.0.1 --port=6001 --env=testing
   ```

   En la segunda inicia Laravel:

   ```powershell
   php artisan serve --host=127.0.0.1 --port=8000 --env=testing
   ```

6. Abre `http://127.0.0.1:8000` y revisa la consola del navegador y la
   terminal de Reverb. Para probar autenticación y eventos hay que iniciar
   sesión con usuarios de prueba creados únicamente en esta base SQLite y
   ejecutar una acción de la aplicación que emita un evento broadcast.

**Importante:** esta plantilla solo prepara la configuración local. Los valores
de ejemplo de Reverb no son credenciales seguras para Internet. No copies
`.env.testing` a DigitalOcean, no uses datos reales y no ejecutes estos pasos
si tu terminal no está situada en la copia de trabajo correcta. Si una migración
no es compatible con SQLite, la alternativa será preparar un esquema de prueba
MySQL local separado; nunca apuntar a la base productiva.

La prueba local usa WebSocket sin TLS en `127.0.0.1:6001`. No demuestra WSS
público, el proxy de Apache ni el comportamiento de App Platform. Esas partes
siguen pendientes de una prueba en un staging HTTPS independiente.
