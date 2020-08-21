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
            'A' => 'A (指定域名对应的IPv4地址)',
            'AAAA' => 'AAAA (指定域名对应的IPv6地址)',
            'CNAME' => 'CNAME (别名记录)',
            'MX' => 'MX (邮件交换记录)',
            'NS' => 'NS (指定该域名由哪个DNS服务器来进行解析)',
            'TXT' => 'TXT (主机名或域名的说明)',
            'SOA' => 'SOA (起始授权机构)',
            'PTR' => 'PTR (反向IP查询)',
            'ANY' => 'ANY (所有DNS记录类型)',
        ];
        $options = [];
        foreach ($type as $k => $v) {
            $options[] = [
                'label' => $v,
                'code' => $k,
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
