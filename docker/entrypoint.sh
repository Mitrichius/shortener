#!/usr/bin/env bash

set -e

wait-for-it shortener-mysql:3306 -t 60
bin/console doctrine:migrations:migrate --no-interaction
echo "Start php-fpm"
php-fpm -F -R