#!/usr/bin/env bash
set -euo pipefail

echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

if ! grep -q '^APP_KEY=base64:' .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "Running database migrations and seeders..."
php artisan migrate --seed --force

echo "Linking public storage..."
php artisan storage:link || true

echo "Caching Laravel config, routes and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deploy complete."
