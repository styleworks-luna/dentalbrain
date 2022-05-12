<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        if (env('APP_ENV') == 'local') {
            DB::listen(function ($query) {
                Log::info("DB QUERIED", [
                    $query->sql,
                    $query->bindings,
                    $query->time
                ]);
            });
        }

        /* @see https://laravel.kr/docs/6.x/validation#%ED%99%95%EC%9E%A5%EA%B8%B0%EB%8A%A5%20%EC%82%AC%EC%9A%A9%ED%95%98%EA%B8%B0
         */
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });
    }
}
