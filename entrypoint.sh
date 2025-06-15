#!/bin/sh

set -e

echo "[entrypoint] DB_HOST=$DB_HOST"
echo "[entrypoint] DB_USER=$DB_USER"
echo "[entrypoint] DB_NAME=$DB_NAME"

exec apache2-foreground
