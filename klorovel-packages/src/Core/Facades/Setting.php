<?php

namespace AyatKyo\Klorovel\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void autoload()
 * @method static void|int|bool cache($key)
 * @method static mixed save($key, $arr = null, $autoload = null)
 * @method static mixed loadFromJsonString($key, $data)
 * @method static \App\SettingCollection loadFromDb(string $key)
 * @method static \App\SettingCollection loadOrCreateFromDb(string $key)
 */
class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \AyatKyo\Klorovel\Core\Services\Setting::class;
    }
}