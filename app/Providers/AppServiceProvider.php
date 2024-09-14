<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Paginator::useBootstrapFour();
        Validator::extend('valid_time', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $value);
        }, 'The :attribute must be a valid time format (H:i or H:i:s).');
    }


    

}
