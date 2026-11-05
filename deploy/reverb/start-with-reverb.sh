#!/usr/bin/env bash
# Candidate launcher for isolated testing only; do not use in production yet.
set -Eeuo pipefail

APP_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$APP_ROOT"

REVERB_HOST="127.0.0.1"
REVERB_PORT="6001"
WEB_PID=""
REVERB_PID=""

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

# Reverb stays on loopback; Apache will proxy the public endpoints to it.
php artisan reverb:start --host="$REVERB_HOST" --port="$REVERB_PORT" &
REVERB_PID=$!

# Do not start Apache until Reverb is listening. Fail closed if it does not start.
ready=0
for attempt in {1..40}; do
    if ! kill -0 "$REVERB_PID" 2>/dev/null; then
        set +e
        wait "$REVERB_PID"
        status=$?
        set -e
        echo "Reverb exited before becoming ready (status $status)." >&2
        exit 1
    fi

    if php -r '$s = @fsockopen($argv[1], (int) $argv[2], $errno, $errstr, 0.2); if ($s) { fclose($s); exit(0); } exit(1);' "$REVERB_HOST" "$REVERB_PORT"; then
        ready=1
        break
    fi
    sleep 0.25
done

if [[ "$ready" != "1" ]]; then
    echo "Reverb did not listen on ${REVERB_HOST}:${REVERB_PORT} within the startup window." >&2
    exit 1
fi

# The existing Heroku PHP launcher continues to supervise Apache and PHP-FPM.
# This wrapper supervises that launcher together with Reverb.
"$APP_ROOT/vendor/bin/heroku-php-apache2" -C deploy/reverb/apache-reverb.conf public/ &
WEB_PID=$!

# If either long-running service exits, terminate the other and fail the container.
set +e
wait -n "$REVERB_PID" "$WEB_PID"
status=$?
set -e

echo "Reverb or the Apache/PHP-FPM launcher exited (status $status); stopping the remaining process." >&2
exit "$status"
