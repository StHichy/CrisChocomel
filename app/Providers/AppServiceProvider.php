<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Adicione esta linha

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Força o Laravel a gerar URLs com HTTPS em ambientes de produção (como o Render)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}