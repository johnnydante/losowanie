<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class Globals extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Globals';
    }
}
