#!/bin/bash
set -e

echo "[edufun-db] Waiting for MySQL to be ready..."

for i in {1..30}; do
  if mysqladmin ping -h127.0.0.1 -uroot -p"$MYSQL_ROOT_PASSWORD" --silent; then
    echo "[edufun-db] MySQL is up."
    break
  fi
  echo "[edufun-db] Waiting... ($i)"
  sleep 1
done

if [ -f /data/.seeded ]; then
  echo "[edufun-db] Already seeded. Skipping."
  exit 0
fi

echo "[edufun-db] Importing edufun.sql..."
mysql -h127.0.0.1 -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE" < /edufun.sql

echo "[edufun-db] Seed completed."

touch /data/.seeded


