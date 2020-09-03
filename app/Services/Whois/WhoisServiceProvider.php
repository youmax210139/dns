<?php

namespace App\Services\Whois;

use Illuminate\Support\ServiceProvider;

class WhoisServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Whois::class, function ($app) {
            return new Whois;
        });
        $this->app->alias(Whois::class, 'whois');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [Whois::class];
    }
}
