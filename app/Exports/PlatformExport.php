<?php

namespace App\Exports;

use App\Models\Platform;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class PlatformExport implements FromCollection, Responsable, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'platforms.xlsx';

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
        'name' => 'platform',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ];

    public function headings(): array
    {
        return collect(array_values($this->fields))->map(function ($v) {
            return __($v);
        })->toArray();
    }

    public function map($platform): array
    {
        return collect(array_keys($this->fields))->map(function ($v) use ($platform) {
            return $platform->$v;
        })->toArray();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Platform::query()
            ->sort(Request::get('sort'))
            ->filter(Request::only('search', 'trashed'))
            ->get();
    }
}
