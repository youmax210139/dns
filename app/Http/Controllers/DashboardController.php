<?php

namespace App\Http\Controllers;

use App\Charts\UserLineChart;
use App\Models\Platform;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

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
            'doughnuts' => $this->getDoughnuts(),
            'bar' => $this->getBar(),
            'line' => $this->getLine(),
        ]);
    }

    protected function getDoughnuts()
    {
        // minutes
        $doughnuts = [
            30,
            60,
        ];
        return $doughnuts;
        // Platform::withCount('domains')->get()->each(function ($platform) use (&$doughnut) {
        //     $doughnut['labels'][] = $platform->name;
        //     $doughnut['data'][] = $platform->domains_count;
        // });
    }

    protected function getBar()
    {
        return [
            'chartdata' => [
                'labels' => ['January', 'February'],
                'datasets' => [
                    [
                        'label' => 'Data One',
                        'backgroundColor' => '#f87979',
                        'data' => [40, 20],
                    ],
                ],
            ],
            'options' => [
                'responsive' => true,
                'maintainAspectRatio' => false,
            ],
        ];
    }

    protected function getLine()
    {
        $chart = new UserLineChart;
        $platforms = Platform::all();

        $chart->dataset('New User Register Chart', 'line', $platforms)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0',
        ]);

        return $chart->api();

    }
}
