<?php

namespace App\Providers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Date::use (CarbonImmutable::class);
        $this->registerObserver();
        $this->registerInertia();
        $this->registerLengthAwarePaginator();
    }

    public function register()
    {
    }

    protected function registerObserver()
    {
        \App\Models\Domain::observe(\App\Observers\DomainObserver::class);
    }

    protected function registerInertia()
    {
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Inertia::share([
            'app' => [
                'name' => config('app.name'),
                'ip' => Cache::remember('ip' . md5(env('APP_URL')), 86400, function () {
                    return file_get_contents("http://ipecho.net/plain");
                }),
            ],
            'auth' => function () {
                return [
                    'user' => Auth::user() ? [
                        'id' => Auth::user()->id,
                        'first_name' => Auth::user()->first_name,
                        'last_name' => Auth::user()->last_name,
                        'email' => Auth::user()->email,
                        'role' => Auth::user()->role,
                    ] : null,
                ];
            },
            'language' => function () {
                if (!\Lang::has('all')) {
                    return [];
                }
                return \Lang::get('all');
            },
            'date' => Carbon::now()->format('Y M'),
            'flash' => function () {
                return [
                    'success' => Session::get('success'),
                    'error' => Session::get('error'),
                ];
            },
            'errors' => function () {
                return Session::get('errors')
                ? Session::get('errors')->getBag('default')->getMessages()
                : (object) [];
            },
        ]);
    }

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class(...array_values($values)) extends LengthAwarePaginator
            {
                public function only(...$attributes)
                {
                    return $this->transform(function ($item) use ($attributes) {
                        return $item->only($attributes);
                    });
                }

                public function transform($callback)
                {
                    $this->items->transform($callback);

                    return $this;
                }

                public function toArray()
                {
                    return array_merge(parent::toArray(), $this->additional ?? []);
                }

                public function merge(array $additiona)
                {
                    $this->additional = $additiona;
                    return $this;
                }
            };
        });
    }
}
