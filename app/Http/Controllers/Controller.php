<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use LaravelLocalization;
use Route;
use Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $shareData = [];

    protected $routeName = '';

    public function __construct()
    {
        $this->routeName = Route::currentRouteName();
        $this->middleware('permission:');
        $this->setupLocale();
        Inertia::share(array_merge($this->shareData, [
            'title' => $this->getPageTitle(),
        ]));
    }

    protected function setupLocale()
    {
        if (Str::contains($this->routeName, ['login', 'logout'])) {
            return;
        }
        $this->shareData['locale_nav'] = collect(LaravelLocalization::getSupportedLocales())
            ->transform(function ($item, $locale) {
                return [
                    'href' => route('locales.index', $locale),
                    'native' => $item['native'],
                    'active' => LaravelLocalization::getCurrentLocale() == $locale,
                    'locale' => $locale,
                ];
            })->values();
    }

    protected function getBreadCrumb()
    {
        $breadcrumb = explode('.', Route::currentRouteName());
        foreach ($breadcrumb as $key => $v) {
            if (in_array($v, ['pings', 'nslookups', 'whois', 'netcats', 'traces', 'dns'])) {
                $breadcrumb = [];
                break;
            } else if (in_array($v, ['index'])) {
                unset($breadcrumb[$key]);
                continue;
            } else if ($key == (count($breadcrumb) - 1)) {
                $breadcrumb[$key] = [
                    'label' => $v,
                ];
            } else {
                $breadcrumb[$key] = [
                    'label' => $v,
                    'link' => "/$v",
                ];
            }
        }
        return $breadcrumb;
    }

    protected function getPageTitle()
    {
        return __('all.' . Route::currentRouteName());
    }

    protected function getDataTableFields(array $fields,
        array $unsortFields = ['actions'],
        array $except = []) {
        return collect($fields)->except($except)->transform(function ($field, $key) use ($unsortFields) {
            if (in_array($key, $unsortFields)) {
                return [
                    'name' => $key,
                    'title' => __('all.' . $field),
                ];
            }
            return [
                'name' => $key,
                'title' => __('all.' . $field),
                'sortField' => $key,
            ];
        })->values();
    }
}
