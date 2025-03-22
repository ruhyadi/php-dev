#!/bin/sh

# Wait for database to be ready (if needed)
# while ! nc -z db 5432; do
#   echo "Waiting for database to be ready..."
#   sleep 1
# done

# Run database migrations
php artisan migrate --force

# Cache configuration and routes in production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor (which manages nginx and php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf