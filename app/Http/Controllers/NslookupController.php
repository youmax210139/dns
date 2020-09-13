<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NslookupController extends Controller
{
    protected function getDnsTypeOptions()
    {
        $type = [
            'A',
            'AAAA',
            'CNAME',
            'MX',
            'NS',
            'TXT',
            'SOA',
            'PTR',
            'ANY',
        ];
        $options = [];
        foreach ($type as $v) {
            $options[] = [
                'label' => __("all.DNS_${v}"),
                'code' => $v,
            ];
        }
        return $options;
    }

    protected function getNameServerOptions()
    {
        $servers = [
            '8.8.8.8' => 'Google Public DNS Server (8.8.8.8)',
            '209.244.0.3' => 'Level 3 Public DNS Server (209.244.0.3)',
            '9.9.9.9' => 'Quad9 Public DNS Server (9.9.9.9)',
            '208.67.222.222' => 'OpenDNS Home Public DNS Server (208.67.222.222)',
            '64.6.64.6' => 'Verisign Public DNS Server (64.6.64.6)',
        ];
        $options = [];
        foreach ($servers as $k => $v) {
            $options[] = [
                'label' => $v,
                'code' => $k,
            ];
        }
        return $options;
    }

    public function create()
    {
        return Inertia::render('Nslookup/Create', [
            'types' => $this->getDnsTypeOptions(),
            'domains' => Domain::orderBy('name')
                ->get()
                ->pluck('name'),
            'nameservers' => $this->getNameServerOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
            'type' => 'required',
            'nameserver' => 'required',
        ]);
        system("nslookup -type={$request->type} {$request->url} {$request->nameserver} 2>&1", $output);
    }
}
