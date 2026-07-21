<?php

namespace App\Providers;

use App\Repositories\Contracts\VehicleEntryRepositoryInterface;
use App\Repositories\VehicleEntryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        VehicleEntryRepositoryInterface::class,
        VehicleEntryRepository::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
