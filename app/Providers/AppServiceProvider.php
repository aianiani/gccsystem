<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\Transport\BrevoApiTransport;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Mail::extend('brevo', function (array $config) {
            return new BrevoApiTransport($config['key'] ?? env('BREVO_API_KEY'));
        });
    }
}
