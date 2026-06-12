<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
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
    public function boot(UrlGenerator $url): void
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

        if (config('app.env') === 'production') {
            // Percayai semua proxy header dari Railway
            Request::setTrustedProxies(
                ['*'],
                Request::HEADER_X_FORWARDED_FOR |
                    Request::HEADER_X_FORWARDED_HOST |
                    Request::HEADER_X_FORWARDED_PORT |
                    Request::HEADER_X_FORWARDED_PROTO
            );

            // Paksa HTTPS untuk generate URL
            $url->forceScheme('https');
        }
    }
}
