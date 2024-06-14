<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserEloquentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Book\BookRepositoryInterface::class,
            \App\Repositories\Book\BookEloquentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Memo\MemoRepositoryInterface::class,
            \App\Repositories\Memo\MemoEloquentRepository::class
        );
    }
}
