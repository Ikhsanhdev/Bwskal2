<?php

namespace App\Providers;

use App\Models\UnduhanAkses;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $_menuBadge = null;
        View::composer([
            'layouts.admin.sidemenu.default',
            'admin.unduhan.index',
        ], function ($view) use (&$_menuBadge) {
            if (! $_menuBadge) {
                $_menuBadge = [];
                
                if (Auth::user() && in_array(Auth::user()->role, ["admin", "supermin"])) {
                    //  Request unduhan
                    $_menuBadge['unduhan_request'] = UnduhanAkses::whereStatus(UnduhanAkses::STATUS_PENDING)->count();
                }
            }
            $view->with('_menuBadge', $_menuBadge);
        });
    }
}
