<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     */
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions());
        $options->addArguments([
            '--no-sandbox',
            '--disable-gpu',
            '--window-size=1920,1080',
            '--disable-dev-shm-usage',
            '--whitelisted-ips=""',
            '--ignore-ssl-errors',
            '--ignore-certificate-errors',
        ]);

        // Add this to help with debugging
        if (!env('DUSK_HEADLESS', false)) {
            $options->addArguments(['--window-size=1920,1080']);
        }

        return RemoteWebDriver::create(
            env('DUSK_DRIVER_URL', 'http://selenium:4444/wd/hub'),
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }

    /**
     * Get the application's base URL.
     */
    protected function baseUrl()
    {
        return 'http://laravel.test';
    }
}
