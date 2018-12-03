<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view){
            $view_name = str_replace('.', '-', $view->getName());
            view()->share('view_name', $view_name);
        });
        User::creating(function ($user) {
            \Log::debug('User create:', [$user]);
        });
        User::updating(function ($user) {
            \Log::debug('User update:', [$user]);
        });
        User::deleting(function ($user) {
            \Log::debug('User delete:', [$user]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
