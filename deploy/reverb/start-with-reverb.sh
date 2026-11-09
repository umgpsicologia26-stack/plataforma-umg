#!/usr/bin/env bash
# Candidato de integración para pruebas aisladas en DigitalOcean App Platform.
# No activar en producción hasta completar las validaciones documentadas.
set -Eeuo pipefail

APP_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$APP_ROOT"

REVERB_HOST="127.0.0.1"
REVERB_PORT="${REVERB_SERVER_PORT:-6001}"
WEB_PID=""
REVERB_PID=""

HEROKU_PHP_APACHE2="$(command -v heroku-php-apache2 || true)"
if [[ -z "$HEROKU_PHP_APACHE2" ]]; then
    echo "No se encontró heroku-php-apache2 en PATH." >&2
    exit 127
fi

cleanup() {
    local pid
    for pid in "$WEB_PID" "$REVERB_PID"; do
        if [[ -n "$pid" ]] && kill -0 "$pid" 2>/dev/null; then
            kill -TERM "$pid" 2>/dev/null || true
        fi
    done
    for pid in "$WEB_PID" "$REVERB_PID"; do
        if [[ -n "$pid" ]]; then
            wait "$pid" 2>/dev/null || true
        fi
    done
}
trap cleanup EXIT
trap 'exit 143' TERM
trap 'exit 130' INT

php artisan reverb:start --host="$REVERB_HOST" --port="$REVERB_PORT" &
REVERB_PID=$!

ready=0
for attempt in {1..40}; do
    if ! kill -0 "$REVERB_PID" 2>/dev/null; then
        set +e
        wait "$REVERB_PID"
        status=$?
        set -e
        echo "Reverb terminó antes de estar disponible (código $status)." >&2
        exit 1
    fi

    if php -r '$s = @fsockopen($argv[1], (int) $argv[2], $errno, $errstr, 0.2); if ($s) { fclose($s); exit(0); } exit(1);' "$REVERB_HOST" "$REVERB_PORT"; then
        ready=1
        break
    fi
    sleep 0.25
done

if [[ "$ready" != "1" ]]; then
    echo "Reverb no abrió ${REVERB_HOST}:${REVERB_PORT} dentro del tiempo esperado." >&2
    exit 1
fi

"$HEROKU_PHP_APACHE2" -C "$APP_ROOT/deploy/reverb/apache-reverb.conf" public/ &
WEB_PID=$!

set +e
wait -n "$REVERB_PID" "$WEB_PID"
status=$?
set -e

echo "Reverb o Apache/PHP-FPM terminó (código $status); deteniendo el proceso restante." >&2
exit "$status"
