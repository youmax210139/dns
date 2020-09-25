<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use LaravelLocalization;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        Inertia::share([
            'breadcrumb' => $this->getBreadCrumb(),
            'title' => $this->getPageTitle(),
            'locale_nav' => $this->getLocaleNav(),
            'sidebar' => $this->getSidebar(),
        ]);

    }

    protected function getSidebar()
    {
        return [
            [
                "label" => __('sidebar.dashboard'),
                "icon" => "business_chart-bar-32",
                "route" => "dashboards.index",
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

    protected function getLocaleNav()
    {
        
        return  collect(LaravelLocalization::getSupportedLocales())
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
        return __('title.' . Route::currentRouteName());
    }

    protected function getDataTableFields(array $fields, array $unsortFields = ['actions'])
    {
        return collect($fields)->transform(function ($field, $key) use ($unsortFields) {
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
