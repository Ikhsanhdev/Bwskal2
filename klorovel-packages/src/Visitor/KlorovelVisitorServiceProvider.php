<?php

namespace AyatKyo\Klorovel\Visitor;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class KlorovelVisitorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\AyatKyo\Klorovel\Visitor\Services\Visitor::class, function () {
            return new \AyatKyo\Klorovel\Visitor\Services\Visitor(app()->request);
        });

        $aliasLoader = AliasLoader::getInstance();
        $aliasLoader->alias('Visitor', \AyatKyo\Klorovel\Visitor\Facades\Visitor::class);
    }

    public function boot()
    {
        
        //  Register Middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('visitor.log', \AyatKyo\Klorovel\Visitor\Middleware\VisitorLog::class);
    }
}
