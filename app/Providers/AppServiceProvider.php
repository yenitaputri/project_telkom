<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Interfaces\SalesInterface;




use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\SalesRepository;


use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(SalesInterface::class, SalesRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Auth::provider('eloquent', function ($app, array $config) {
            return new \Illuminate\Auth\EloquentUserProvider($app['hash'], User::class);
        });
    }
    

}
