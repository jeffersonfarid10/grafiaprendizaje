<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//IMPORTAR ESTA CLASE PARA LA PAGINACION DE LAS TABLAS DE ADMINLTE CON BOOTSTRAP
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //REFERENCIAR A LA PAGINACION PARA QUE USE BOOTSTRAP
        Paginator::useBootstrap();
    }
}
