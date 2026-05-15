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
        //repository
        $this->app->bind(\App\Repositories\UserRepository::class);
        $this->app->bind(\App\Repositories\NoteRepository::class);
        $this->app->bind(\App\Repositories\LabelRepository::class);

        //sý Service
        $this->app->bind(\App\Services\AppearanceService::class);
        $this->app->bind(\App\Services\NoteService::class);
        $this->app->bind(\App\Services\ImageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
