<?php

namespace Invoyer\SmsSender;

use Illuminate\Support\ServiceProvider;

class SmsSenderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sms-sender.php', 'sms-sender');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configurePublishing();
    }

    /**
     * Configure package publishable files.
     *
     * @return void
     */
    private function configurePublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/sms-sender.php' => config_path('sms-sender.php'),
            ], 'seo-settings.config');
        }
    }
}