<?php

namespace AyatKyo\Klorovel;

use AyatKyo\Klorovel\Core\Rules\UniqSlug;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class KlorovelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\AyatKyo\Klorovel\Core\Services\Setting::class, function () {
            return new \AyatKyo\Klorovel\Core\Services\Setting;
        });
    }

    public function boot()
    {
        //  Patch laravel mix
        config(['app.mix_url' => url('/')]);
        
        //  Register Router Mixin
        Route::mixin(new \AyatKyo\Klorovel\Core\Mixins\RouterMixin);
        Route::mixin(new \AyatKyo\Klorovel\Auth\RouterMixin);

        //  Macro
        \Illuminate\Database\Query\Builder::macro('fullSql', function () {
            return macro_fullsql($this);
        });
        \Illuminate\Database\Eloquent\Builder::macro('fullSql', function () {
            return macro_fullsql($this);
        });

        //  Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        \AyatKyo\Klorovel\Core\Facades\Setting::autoload();
        
        //  Register Middleware
        /** @var \Illuminate\Routing\Router  */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth.role', \AyatKyo\Klorovel\Auth\Middleware\AuthRole::class);

        //  Blade
        Blade::if('role', function (...$role) {
            if (! is_array($role)) $role = [$role];
            return Auth::user() && in_array(Auth::user()->role, $role);
        });
        Blade::directive('sessionErrorToast', function () {
            return "<?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>";
        });

        //  Validation Rules
        Validator::extend('uniq_slug_model', function ($attribute, $value, $parameters, $validator) {
            return (new UniqSlug($parameters[0] ?? null, $parameters[1] ?? null, $parameters[2] ?? null))->setValidator($validator)->passes($attribute, $value);
        });
        Validator::extend('routable', function ($attribute, $value, $params, $validator) {
            foreach (Route::getRoutes() as $route) {
                if ($route->uri() == $value) {
                    return false;
                }
            }

            return true;
        });
    }
}
