<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Platform;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $domains = [
            'season' => Domain::where('expired_at', '<=', now()
                    ->addMonths(3))->paginate(10, ['*'], 'season')
                ->only('id', 'name', 'expired_at', 'platform_name'),
            'month' => Domain::where('expired_at', '<=', now()
                    ->addMonths(1))->paginate(10, ['*'], 'month')
                ->only('id', 'name', 'expired_at', 'platform_name'),
            'week' => Domain::where('expired_at', '<=', now()
                    ->addWeeks(1))->paginate(10, ['*'], 'week')
                ->only('id', 'name', 'expired_at', 'platform_name'),
        ];
        $doughnut = [
            'labels' => [],
            'data' => [],
        ];
        Platform::withCount('domains')->get()->each(function ($platform) use (&$doughnut) {
            $doughnut['labels'][] = $platform->name;
            $doughnut['data'][] = $platform->domains_count;
        });
        return Inertia::render('Dashboards/Index', [
            'domains' => $domains,
            'doughnut' => $doughnut,
        ]);
    }
}
