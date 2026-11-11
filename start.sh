#!/usr/bin/env bash

set -Eeuo pipefail

echo "Iniciando Laravel Reverb..."

php artisan reverb:start \
    --host=127.0.0.1 \
    --port="${REVERB_SERVER_PORT:-6001}" \
    --no-interaction &

REVERB_PID=$!

echo "Reverb iniciado con PID: $REVERB_PID"

echo "Iniciando Apache y PHP..."

heroku-php-apache2 -C apache_app.conf public/ &

APACHE_PID=$!

cleanup() {
    echo "Deteniendo los procesos..."

    kill "$APACHE_PID" "$REVERB_PID" 2>/dev/null || true

    wait "$APACHE_PID" 2>/dev/null || true
    wait "$REVERB_PID" 2>/dev/null || true
}

trap cleanup EXIT INT TERM

set +e
wait -n "$REVERB_PID" "$APACHE_PID"
STATUS=$?
set -e

exit "$STATUS"
