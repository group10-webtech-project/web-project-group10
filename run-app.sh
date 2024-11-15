#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x run-app.sh`
# Run migrations, process the Nginx configuration template and start Nginx
sail up -d
sail artisan migrate:fresh --force --seed && node /assets/scripts/prestart.mjs /assets/nginx.template.conf /nginx.conf && (
    php-fpm -y /assets/php-fpm.conf &
    nginx -c /nginx.conf
)
