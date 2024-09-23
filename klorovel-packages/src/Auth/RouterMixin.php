<?php

namespace AyatKyo\Klorovel\Auth;

use Illuminate\Support\Facades\Route;

class RouterMixin
{
    public function KlorovelAuth()
    {
        return function ($options = []) {
            Route::namespace('\\' . __NAMESPACE__ . '\\Controllers')
                ->group(function () {
                    Route::get('login', 'LoginController@show')
                        ->middleware('guest')
                        ->name('login');
                    Route::post('login', 'LoginController@store')
                        ->middleware('guest')
                        ->name('login.post');
                    Route::post('logout', 'LoginController@destroy')
                        ->name('logout');
                });
        };
    }
}