<?php

namespace App\Providers;

use App\Repositories\AnalyticTypeRepository;
use App\Repositories\Contracts\AnalyticTypeRepositoryInterface;
use App\Repositories\Contracts\PropertyRepositoryInterface;
use App\Repositories\PropertyRepository;
use App\Services\AnalyticService;
use App\Services\Contracts\AnalyticServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindRepositories();
        $this->bindServices();
    }

    /**
     * Bind Repositories
     */
    protected function bindRepositories()
    {
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(AnalyticTypeRepositoryInterface::class, AnalyticTypeRepository::class);
    }

    /**
     * Bind Services
     */
    protected function bindServices()
    {
        $this->app->bind(AnalyticServiceInterface::class, AnalyticService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
