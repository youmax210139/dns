<?php

namespace App\Exports;

use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Request;

class LogExport extends BaseExport
{

    protected $tableName = '';
    protected $fileName = '';

    protected $fields = [
        'id' => 'id',
        'level_name' => 'level',
        'created_at' => 'date',
        'message' => 'content',
    ];

    public function __construct($filename)
    {
        $this->tableName = $filename;
        $this->fileName = "log-{$filename}.xlsx";
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return LogRepository::setTable($this->tableName)
            ->sort(Request::get('sort'))
            ->filter(Request::only('search'))
            ->get();
    }
}
