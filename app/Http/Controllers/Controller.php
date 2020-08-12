<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;
use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

        Inertia::share([
            'breadcrumb' => $this->getBreadCrumb(),
            'title' => $this->getPageTitle(),
        ]);

    }

    protected function getBreadCrumb()
    {
        $breadcrumb = explode('.', Route::currentRouteName());
        foreach ($breadcrumb as $key => $v) {
            if (in_array($v, ['pings', 'whois', 'netcats', 'traces', 'dns'])) {
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
}
