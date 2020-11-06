<?php

namespace App\Services\LogViewer;

use Illuminate\Support\ServiceProvider;

class LogViewerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LogViewer::class, function ($app) {
            return new LogViewer;
        });
        $this->app->alias(LogViewer::class, 'logviewer');
    }

    public function boot()
    {
    }

    public function provides()
    {
        return [LogViewer::class];
    }

}
