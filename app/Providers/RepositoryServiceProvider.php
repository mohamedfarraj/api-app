<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register Interface and Repository in here
        // You must place Interface in first place
        // If you dont, the Repository will not get readed.

        // Register Interface and Repository Auth
        $this->app->bind(
            'App\Interfaces\AuthInterface',
            'App\Repositories\AuthRepository'
        );


        // Register Interface and Repository User
        $this->app->bind(
            'App\Interfaces\UserInterface',
            'App\Repositories\UserRepository'
        );

        // Register Interface and Repository Products
        $this->app->bind(
            'App\Interfaces\ProductsInterface',
            'App\Repositories\ProductsRepository'
        );

        
    }
}