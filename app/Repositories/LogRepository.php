<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Support\Facades\Schema;

class LogRepository
{
    protected $model = null;

    public function __construct($name = null)
    {
        $this->model = new Log;
        $this->model->setTable($name);
    }

    public static function getAllTables()
    {
        return array_map('head', Schema::connection('log')->getAllTables());
    }

    public static function __callStatic($method, $args)
    {
        return forward_static_call_array([(new static )->model, $method], $args);
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }
}
