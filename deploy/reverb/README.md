# Prueba aislada: Laravel Reverb en el Web Service existente

**Estado: preparación; no habilitado en producción.**

Esta carpeta contiene únicamente una configuración candidata para evaluar
Reverb dentro del mismo contenedor que ejecuta Apache/PHP-FPM en DigitalOcean
App Platform. No se debe copiar ni activar en producción hasta completar las
comprobaciones indicadas abajo.

## Diseño que se quiere validar

- Apache conserva el puerto público actual `8080`.
- Reverb escucha internamente en `127.0.0.1:6001`.
- Apache reenvía `/app` mediante WebSocket y `/apps` mediante HTTP a Reverb.
- El navegador se conecta al dominio HTTPS existente, usando WSS por el puerto
  público 443. No se expone el puerto 6001 a Internet.
- La configuración de escucha interna (`REVERB_SERVER_HOST`,
  `REVERB_SERVER_PORT`) es distinta de la dirección pública del cliente
  (`REVERB_HOST`, `REVERB_PORT`, `REVERB_SCHEME`).

## Archivo candidato

`apache-reverb.conf` contiene las reglas ProxyPass. Está separado del
`.htaccess` de Laravel y no modifica la configuración actual de Apache.

## Comprobaciones obligatorias antes de cualquier despliegue

1. Confirmar la versión de Apache y que el módulo proxy WebSocket está cargado.
2. Confirmar que el comando `heroku-php-apache2` disponible en el contenedor
   acepta una configuración adicional de Apache mediante `-C`.
3. Definir cómo se supervisarán Apache/PHP-FPM y Reverb como procesos hermanos.
   No basta con iniciar Reverb en segundo plano con `&`: si Reverb termina,
   el contenedor debe detectar el fallo y reiniciar o finalizar de forma
   controlada.
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

Este cambio no instala servicios, no modifica dependencias, no cambia archivos
existentes, no ajusta variables de DigitalOcean y no despliega nada. La
configuración es una propuesta para revisión técnica, no una instrucción para
activarla directamente.
