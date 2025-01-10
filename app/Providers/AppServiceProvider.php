<?php

namespace App\Providers;

use App\Domain\Repositories\DebtRepositoryInterface;
use App\Domain\Repositories\InvoiceRepositoryInterface;
use App\Infrastructure\Repositories\DebtRepository;
use App\Infrastructure\Repositories\InvoiceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(DebtRepositoryInterface::class, DebtRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
