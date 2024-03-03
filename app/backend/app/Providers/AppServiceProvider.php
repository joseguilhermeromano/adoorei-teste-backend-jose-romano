<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\SaleRepositoryInterface;
use App\Repositories\SaleRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
