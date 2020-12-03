<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Platform;
use Inertia\Inertia;
use Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $doughnut = [
            'labels' => [],
            'data' => [],
        ];
        Platform::withCount('domains')->get()->each(function ($platform) use (&$doughnut) {
            $doughnut['labels'][] = $platform->name;
            $doughnut['data'][] = $platform->domains_count;
        });
        return Inertia::render('Dashboards/Index', [
            'expirationFields' => $this->getDataTableFields([
                'platform_name' => 'platform',
                'name' => 'domain',
                'expired_at' => 'expired_at',
            ]),
            'statusFields' => $this->getDataTableFields([
                'platform_name' => 'platform',
                'name' => 'domain',
                'protocols' => 'protocol',
                'status_code' => 'status_code',
            ]),
            'doughnut' => $doughnut,
        ]);
    }
}
