# INFO
We will be using `sail` for Laravel's _Dockerization_.  Read the documentation at:
> https://laravel.com/docs/11.x/sail

## Install `sail`
```shell
composer require laravel/sail --dev
```

## Copy the environment
```shell
cp .env.example .env
```

## Then configure a shell `alias`
```shell
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
To make it permanent add above line to your `.zshrc` or `.bashrc` and source it:
```shell
nano ~/.zshrc
# paste the alias command and save the file
source ~/.zshrc
```


else you will have to call `sail` with relative path:
```shell
# without alias
./vendor/bin/sail

# with alias
sail
```

## RUN
To start all of the Docker containers defined in your application's `docker-compose.yml` file, you should execute the `up` command:
```shell
# You may run your Docker containers using Sail's "up" command.  
sail up
```
To start all of the Docker containers in the background, you may start Sail in "detached" mode:
```shell
sail up -d
```
Once the application's containers have been started, you may access the project in your web browser at: http://localhost.

## Database
```shell
# Generate the encryption key:
sail artisan key:generate

# Run "artisan migrate" to run database migrations:  
sail artisan migrate

# Run 'seeds' - populate the database
sail artisan db:seed

# To regenerate the migrations and populate(seed) the database run:
sail artisan migrate:fresh --seed
```

then

### Install `breeze` 
- in order to use `interia` and `vue.js`
```shell
./vendor/bin/sail composer require laravel/breeze --dev


sail artisan migrate
npm install
npm run dev
```
## Quick run (for development)
```shell
sail up -d
npm run dev
```

# Executing Commands

When using Laravel Sail, your application is executing within a Docker container and is isolated from your local computer. However, Sail provides a convenient way to run various commands against your application such as arbitrary PHP commands, Artisan commands, Composer commands, and Node / NPM commands.

When reading the Laravel documentation, you will often see references to Composer, Artisan, and Node / NPM commands that do not reference Sail. Those examples assume that these tools are installed on your local computer. If you are using Sail for your local Laravel development environment, you should execute those commands using Sail:

```shell
# Running Artisan commands locally...
php artisan queue:work

# Running Artisan commands within Laravel Sail...
sail artisan queue:work
```
For more info read:
> https://laravel.com/docs/11.x/sail#executing-sail-commands

# ER Diagram

![Er Diagram](./database/er_diagram.webp)

# Testing

## Prerequisites
- Make sure you're running Laravel Sail with Docker
- If you're using Apple Silicon (M1/M2) Mac, the Selenium container needs to be configured specifically for ARM64 architecture

## Environment Setup
1. Copy the Dusk environment file:
```shell
cp .env.example .env.dusk.local
```

2. Configure your `.env.dusk.local`:
```env
APP_URL=http://laravel.test
DUSK_DRIVER_URL=http://selenium:4444/wd/hub
DUSK_HEADLESS=false  # Set to true for headless testing
```

## Running Tests

### All Tests
```shell
# Run all tests (Unit, Feature, and Browser)
sail test

# Run only Browser/Dusk tests
sail dusk
```

### Specific Test Suites
```shell
# Run only Unit tests
sail test --testsuite=Unit

# Run only Feature tests
sail test --testsuite=Feature

# Run only Browser/Dusk tests
sail test --testsuite=Browser/Dusk
```

### Single Test File
```shell
# Run a specific test file
sail dusk tests/Browser/ExampleTest.php
```

### Single Test Method
```shell
# Run a specific test method
sail dusk tests/Browser/ExampleTest.php --filter=testBasicExample
```

## Troubleshooting

### Architecture-Specific Issues
If you're using Apple Silicon (M1/M2) Mac, ensure your `docker-compose.yml` uses the ARM64-compatible Selenium image:
```yaml
selenium:
    image: 'seleniarm/standalone-chromium'
    volumes:
        - '/dev/shm:/dev/shm'
```

### Common Issues

1. **Connection Refused Error**
   - Ensure all containers are running: `sail ps`
   - Check Selenium status: `curl http://localhost:4444/wd/hub/status`
   - Verify Laravel is accessible: `curl http://laravel.test`

2. **Browser Not Visible**
   - Set `DUSK_HEADLESS=false` in `.env.dusk.local`
   - You can view the browser via VNC at `localhost:7900` (password: "secret")

3. **Test Environment Reset**
```shell
# Clear caches
sail artisan config:clear
sail artisan cache:clear
sail artisan route:clear

# Rebuild containers
sail down
sail build --no-cache
sail up -d
```

## Visual Debugging
For visual debugging of browser tests:
1. Set `DUSK_HEADLESS=false` in `.env.dusk.local`
2. Connect to VNC viewer at `localhost:7900` (password: "secret")
3. Run your tests to see the browser automation in real-time

## Screenshots and Console Logs
Dusk automatically takes screenshots of failures and console logs. Find them in:
- Screenshots: `tests/Browser/screenshots`
- Console Logs: `tests/Browser/console`
