<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        // Definición de limitador para API: 60 req/min por usuario autenticado o IP.
        RateLimiter::for('api', function (Request $request) {
            $userId = optional($request->user())->id;
            return $userId
                ? Limit::perMinute(60)->by('user:'.$userId)
                : Limit::perMinute(60)->by($request->ip());
        });
    }
}
