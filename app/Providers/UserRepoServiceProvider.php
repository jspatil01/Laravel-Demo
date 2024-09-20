<?php

namespace App\Providers;

use App\interface\UserInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use PhpParser\Builder\Interface;

class UserRepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
