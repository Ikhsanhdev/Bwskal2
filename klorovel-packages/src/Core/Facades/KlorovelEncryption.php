<?php

namespace AyatKyo\Klorovel\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string encrypt($string, $acak = '')
 * @method static mixed decrypt($string, $acak = '')
 */
class KlorovelEncryption extends Facade {
    public static function getFacadeAccessor()
    {
        return \AyatKyo\Klorovel\Core\Services\KlorovelEncryption::class;
    }
}
