<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Esto fuerza a Laravel a generar todas las URLs con 'https'
        // Lo aplicamos en 'production' (Render) para evitar contenido mixto.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
