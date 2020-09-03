<?php
namespace App\Services\Whois;

use Illuminate\Support\Facades\Facade;

class WhoisFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'whois';
    }
}
