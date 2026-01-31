#!/usr/bin/env bash
php -d extension=/usr/lib/php/modules/pdo_mysql.so artisan "$@"
