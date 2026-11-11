#!/usr/bin/env bash
set -Eeuo pipefail

echo "Iniciando Laravel Reverb..."

php artisan reverb:start \
    --host=127.0.0.1 \
    --port="${REVERB_SERVER_PORT:-6001}" \
    --no-interaction &

REVERB_PID=$!

cleanup() {
    kill "$REVERB_PID" 2>/dev/null || true
    wait "$REVERB_PID" 2>/dev/null || true
}

trap cleanup EXIT INT TERM

echo "Iniciando Apache..."

heroku-php-apache2 -C apache_app.conf public/