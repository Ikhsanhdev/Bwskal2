<?php

namespace AyatKyo\Klorovel\Core\Facades;

use Illuminate\Support\Facades\Facade;

class KlorovelToken extends Facade {
    public static function getFacadeAccessor()
    {
        return \AyatKyo\Klorovel\Core\Services\KlorovelToken::class;
    }
}