<?php

namespace App\Exports;

use App\Models\Platform;
use Illuminate\Support\Facades\Request;

class PlatformExport extends BaseExport
{

    protected $fileName = 'platforms.xlsx';

    protected $fields = [
        'id' => 'id',
        'name' => 'platform',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ];

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
