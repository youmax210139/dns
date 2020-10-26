<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;
use Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    protected function getMenus()
    {
        return [
            [
                "icon" => "business_chart-bar-32",
                "route" => "dashboards.index",
            ],
            [
                "icon" => "business_badge",
                "route" => "roles.index",
            ],
            [
                "icon" => "users_single-02",
                "route" => "users.index",
            ],
            [
                "icon" => "files_paper",
                "route" => "logs.index",
            ],
            [
                "icon" => "business_globe",
                "route" => "platforms.index",
            ],
            [
                "icon" => "business_money-coins",
                "route" => "domains.index",
            ],
            [
                "icon" => "media-2_sound-wave",
                "route" => "pings.create",
            ],
            [
                "icon" => "gestures_tap-01",
                "route" => "nslookups.create",
            ],
            [
                "icon" => "education_paper",
                "route" => "traces.create",
            ],
            [
                "icon" => "travel_info",
                "route" => "whois.create",
            ],
            [
                "icon" => "ui-2_settings-90",
                "route" => "netcats.create",
            ],
        ];
    }

    protected function getPermissionViaRoute($routeName)
    {
        $routeName = str_replace('.update', '.edit', $routeName);
        $routeName = str_replace('.store', '.create', $routeName);
        $routeName = str_replace('.restore', '.destroy', $routeName);
        $routeName = str_replace('.show', '.index', $routeName);
        return $routeName;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $guard = null)
    {
        $routeName = Route::currentRouteName();
        switch ($routeName ) {
            case 'login':
            case 'logout':
            case 'login.attempt':
            case 'locales.index':
            case 'images.show':
                return $next($request);
        }

        $permission = $this->getPermissionViaRoute($routeName);
        if (app('auth')->guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        if (app('auth')->guard($guard)->user()->can($permission)) {
            $permissions = app('auth')->guard($guard)->user()->getAllPermissions()->pluck('name');
            $sidebar = [];
            foreach ($this->getMenus() as $menu) {
                foreach ($permissions as $p) {
                    if ($menu['route'] == $p) {
                        $menu['label'] = __('all.'. $p);
                        $sidebar[] = $menu;
                        break;
                    }
                }
            }
            Inertia::share('sidebar', $sidebar);
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }
}
