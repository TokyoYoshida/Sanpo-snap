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
