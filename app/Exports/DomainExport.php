<?php

namespace App\Exports;

use App\Models\Domain;
use Illuminate\Support\Facades\Request;

class DomainExport extends BaseExport
{
    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    protected $fileName = 'domains.xlsx';

    protected $fields = [
        'id' => 'id',
        'platform_name' => 'platform',
        'hostname' => 'main_domain',
        'name' => 'domain',
        'protocols' => 'protocol',
        // 'usage' => 'usage',
        'backup' => 'backup',
        'enable' => 'enable',
        'status_code' => 'status_code',
        'remark' => 'remark',
        'expired_at' => 'expired_at',
    ];

    public function map($domain): array
    {
        return collect(array_keys($this->fields))->map(function ($v) use ($domain) {
            switch ($v) {
                case 'usage':
                    return $domain->$v . '%';
                case 'enable':
                case 'backup':
                    return $domain->$v ? 'Y' : 'N';
                default:
                    return $domain->$v;
            }
        })->toArray();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Domain::leftjoin('platforms', 'domains.platform_id', '=', 'platforms.id')
            ->select('domains.*', 'platforms.name as platform_name')
            ->sort(Request::get('sort'))
            ->filter(Request::only('search', 'trashed', 'expired', 'status'))
            ->get();
    }
}
