#!/usr/bin/env bash

set -e 

role=${CONTAINER_ROLE}

if [ "$role" = "server" ]; then
    exec apache2-foreground
elif [ "$role" = "queue" ]; then
    php artisan queue:work
fi