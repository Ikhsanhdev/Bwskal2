<?php

namespace AyatKyo\Klorovel\Core\Mixins;

use AyatKyo\Klorovel\Core\Mixins\Router\KlorovelResource;

class RouterMixin
{
    /**
     * @return \AyatKyo\Klorovel\Core\Mixins\Router\KlorovelResource
     */
    public function KlorovelResource()
    {
        /**
         * @return \AyatKyo\Klorovel\Core\Mixins\Router\KlorovelResource
         */
        return function ($name, $controller, array $options = []) {
            /** @var \Illuminate\Routing\Router $this */
            return new KlorovelResource(
                $this,
                $name,
                $controller,
                $options
            );
        };
    }
}