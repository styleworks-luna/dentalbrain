<?php

namespace App\Providers;

use Iamport\RestClient\Iamport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* @see https://laravel.kr/docs/6.x/validation#%ED%99%95%EC%9E%A5%EA%B8%B0%EB%8A%A5%20%EC%82%AC%EC%9A%A9%ED%95%98%EA%B8%B0
         */
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $this->app->singleton(Iamport::class, function ($app) {
            return new Iamport('impKey', 'impSecret');
        });
    }
}
