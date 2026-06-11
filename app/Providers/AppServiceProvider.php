<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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
        if (config('app.debug')) {
            DB::listen(function ($query) {
                if ($query->time > 100) { // log query > 100ms
                    logger()->warning('Slow query', [
                        'sql'  => $query->sql,
                        'time' => $query->time . 'ms',
                    ]);
                }
            });
        }
    }
}
