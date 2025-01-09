<?php

namespace App\Providers;

use App\Domain\Repositories\DebtRepositoryInterface;
use App\Infrastructure\Repositories\DebtRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
