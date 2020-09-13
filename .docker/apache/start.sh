#!/usr/bin/env bash

set -e 

role=${CONTAINER_ROLE}

if [ "$role" = "server" ]; then
    exec apache2-foreground
elif [ "$role" = "queue" ]; then
    php artisan queue:work
elif [ "$role" = "broadcast-server" ]; then
    php artisan websockets:serve
fi