#!/bin/sh

set -e

echo "[entrypoint] DB_HOST=$DB_HOST"
echo "[entrypoint] DB_USER=$DB_USER"
echo "[entrypoint] DB_NAME=$DB_NAME"
echo "[entrypoint] Checking /tmp/edufun.sql ..."
ls -la /tmp || echo "[entrypoint] /tmp does not exist? wtf?"
ls -la /tmp/edufun.sql || echo "[entrypoint] /tmp/edufun.sql not found."

if [ "$SHOULD_IMPORT_DB" = "true" ]; then
  echo "[entrypoint] Starting DB import ..."
  sleep 5
  mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < /tmp/edufun.sql || echo "[entrypoint] SEVERE: Failed to import edufun.sql"
else
  echo "[entrypoint] DB import skipped."
fi

exec apache2-foreground
