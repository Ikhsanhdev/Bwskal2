<?php

namespace AyatKyo\Klorovel\Visitor\Facades;

use Illuminate\Support\Facades\Facade;

class Visitor extends Facade
{
    public static function getFacadeAccessor()
    {
        return \AyatKyo\Klorovel\Visitor\Services\Visitor::class;
    }
}
