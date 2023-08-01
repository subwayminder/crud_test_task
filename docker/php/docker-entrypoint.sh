#!/bin/sh

cd /var/www/html/ || exit

if [ "$COMPOSER_INSTALL" = true ]; then
    composer install --optimize-autoloader
fi

if [ "$SCHEDULE_RUN" = true ]; then
    echo "* * * * * www-data /usr/local/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1" >> /etc/cron.d/laravel-scheduler
    chmod 0644 /etc/cron.d/laravel-scheduler
fi

php artisan migrate --force
php artisan config:cache
php artisan route:cache

php-fpm
