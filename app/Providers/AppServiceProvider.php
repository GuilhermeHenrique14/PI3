<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <-- Adicione esta linha

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
        Paginator::useBootstrapFive(); // <-- Adicione esta linha
        // Se você também usa simplePaginate em algum lugar e quer o estilo Bootstrap 5 para ele:
        // Paginator::useBootstrapFiveSimple(); 
    }
}