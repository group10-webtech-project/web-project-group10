#!/bin/bash
shopt -s expand_aliases
#source ~/.bashrc
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
# Make sure this file has executable permissions, run `chmod +x run-app.sh`
# Run migrations, process the Nginx configuration template and start Nginx
sail up -d
sail artisan migrate:fresh --force --seed && (sail artisan reverb:start & sail artisan queue:listen)
