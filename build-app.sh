#!/bin/bash

composer require laravel/sail --dev
cp .env.example .env
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'

# Build assets using NPM
npm run build

sail up -d

# Clear cache
sail artisan optimize:clear

# Cache the various components of the Laravel application
sail artisan config:cache
sail artisan event:cache
sail artisan route:cache
sail artisan view:cache
