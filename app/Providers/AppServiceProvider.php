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
        // Rate limit public application submissions by IP
        RateLimiter::for('application-submissions', function (Request $request) {
            $key = $request->ip() ?: 'global';
            return [
                Limit::perMinute(3)->by($key),
                Limit::perHour(30)->by($key),
            ];
        });
    }
}
