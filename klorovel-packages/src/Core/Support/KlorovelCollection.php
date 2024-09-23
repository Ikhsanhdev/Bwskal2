<?php

namespace AyatKyo\Klorovel\Core\Support;

use Illuminate\Support\Collection;

class KlorovelCollection extends Collection
{
    public function __get($key) {
        if (! $this->has($key)) {
            return null;
        }

        return $this->get($key);
    }
    public function __set($key, $value) {
        $this->put($key, $value);
    }

    public static function fromJson($jsonstring) {
        return new static(json_decode($jsonstring));
    }
}