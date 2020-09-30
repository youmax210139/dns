<?php
namespace App\Services\Http;

use Illuminate\Support\Facades\Facade;

class HttpFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'http';
    }
}
