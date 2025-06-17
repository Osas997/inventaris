<?php

namespace App\Providers;

use App\Interfaces\Repositories\CategoryRepository;
use App\Interfaces\Repositories\ProductRepository;
use App\Interfaces\Services\AuthService;
use App\Interfaces\Services\CategoryService;
use App\Interfaces\Services\ProductService;
use App\Repositories\CategoryRepositoryImpl;
use App\Repositories\ProductRepositoryImpl;
use App\Services\AuthServiceImpl;
use App\Services\CategoryServiceImpl;
use App\Services\ProductServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
        $this->app->bind(ProductService::class, ProductServiceImpl::class);
        $this->app->bind(CategoryService::class, CategoryServiceImpl::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryImpl::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
