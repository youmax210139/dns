<?php

namespace App\Exports;

use App\Models\Domain;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DomainExport implements FromCollection, Responsable, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'domains.xlsx';

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    protected $fields = [
        'id' => 'id',
        'hostname' => 'main_domain',
        'name' => 'domain',
        'usage' => 'usage',
        'backup' => 'backup',
        'expired_at' => 'expired_at',
        'platform_name' => 'platform',
        'http_status_code' => 'http_status_code',
    ];

    public function headings(): array
    {
        return collect(array_values($this->fields))->map(function($v){
            return __($v);
        })->toArray();
    }

    public function map($domain): array
    {
        return collect(array_keys($this->fields))->map(function($v) use ($domain){
            return $domain->$v;
        })->toArray();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Domain::leftjoin('platforms', 'domains.platform_id', '=', 'platforms.id')
            ->select('domains.*', 'platforms.name as platform_name', 'domains.http->Status_code as http_status_code')
            ->sort(Request::get('sort'))
            ->filter(Request::only('search', 'trashed', 'expired', 'status'))
            ->get();
    }
}
