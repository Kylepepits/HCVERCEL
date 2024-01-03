
#!/usr/bin/env bash

echo "Running composer"
composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

echo "Updating composer"
composer update --no-scripts --working-dir=/var/www/html


echo "Updating barryvdh/laravel-cors to the latest version..."
composer require barryvdh/laravel-cors:^3.0.0 --no-scripts --working-dir=/var/www/html


echo "Running composer dump-autoload"
composer dump-autoload --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache



echo "Running migrations..."
php artisan migrate --force --seed



