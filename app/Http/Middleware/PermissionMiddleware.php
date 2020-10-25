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
                "label" => __('sidebar.dashboard'),
                "icon" => "business_chart-bar-32",
                "route" => "dashboards.index",
            ],
            [
                "label" => __('sidebar.role'),
                "icon" => "business_badge",
                "route" => "roles.index",
            ],
            [
                "label" => __('sidebar.user'),
                "icon" => "users_single-02",
                "route" => "users.index",
            ],
            [
                "label" => __('sidebar.platform'),
                "icon" => "business_globe",
                "route" => "platforms.index",
            ],
            [
                "label" => __('sidebar.domain'),
                "icon" => "business_money-coins",
                "route" => "domains.index",
            ],
            [
                "label" => __('sidebar.ping'),
                "icon" => "media-2_sound-wave",
                "route" => "pings.create",
            ],
            [
                "label" => __('sidebar.nslookup'),
                "icon" => "gestures_tap-01",
                "route" => "nslookups.create",
            ],
            [
                "label" => __('sidebar.trace'),
                "icon" => "education_paper",
                "route" => "traces.create",
            ],
            [
                "label" => __('sidebar.whois'),
                "icon" => "travel_info",
                "route" => "whois.create",
            ],
            [
                "label" => __('sidebar.netcat'),
                "icon" => "ui-2_settings-90",
                "route" => "netcats.create",
            ],
        ];
    }

    protected function getPermissionViaRoute()
    {
        $routeName = Route::currentRouteName();
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
        $permission = $this->getPermissionViaRoute();
        switch ($permission) {
            case 'login':
            case 'logout':
            case 'login.attempt':
            case 'locales.index':
            case 'images.show':
                return $next($request);
        }
        if (app('auth')->guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        if (app('auth')->guard($guard)->user()->can($permission)) {
            $permissions = app('auth')->guard($guard)->user()->getAllPermissions()->pluck('name');
            $sidebar = [];
            foreach ($this->getMenus() as $menu) {
                foreach ($permissions as $p) {
                    if ($menu['route'] == $p) {
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
