<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Enforce WIB (Asia/Jakarta) Timezone across the entire application
        date_default_timezone_set('Asia/Jakarta');
        config(['app.timezone' => 'Asia/Jakarta']);

        if (request()->header('X-Forwarded-Proto') === 'https' || str_contains(config('app.url', ''), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
