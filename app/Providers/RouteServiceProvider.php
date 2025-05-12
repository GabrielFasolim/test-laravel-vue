<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {

            /*  ROTAS API  ------------------------------------ */
            Route::middleware('api')          // ← carrega o grupo “api”
                ->prefix('api')               // ← adiciona /api no início
                ->group(base_path('routes/api.php'));

            /*  ROTAS WEB  ------------------------------------ */
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
