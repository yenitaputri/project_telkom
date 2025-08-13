<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Interfaces
use App\Contracts\Interfaces\UserInterface;
use App\Contracts\Interfaces\SalesInterface;
use App\Contracts\Interfaces\SearchInterface;

// Repositories
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\SalesRepository;
use App\Repositories\SearchRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binding Repositories
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(SalesInterface::class, SalesRepository::class);
        $this->app->bind(SearchInterface::class, SearchRepository::class); // tambahkan ini
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('eloquent', function ($app, array $config) {
            return new \Illuminate\Auth\EloquentUserProvider($app['hash'], User::class);
        });
    }
}
