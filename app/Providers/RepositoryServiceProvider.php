<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\ICategoryRepository;
use App\Repositories\Feature\FeatureRepository;
use App\Repositories\Feature\IFeatureRepository;
use App\Repositories\FileUpload\FileUploadRepository;
use App\Repositories\FileUpload\IFileUploadRepository;
use App\Repositories\Product\IProductRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;



class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: IUserRepository::class, concrete: UserRepository::class);
        $this->app->bind(abstract: IFileUploadRepository::class, concrete: FileUploadRepository::class);
        $this->app->bind(abstract: ICategoryRepository::class, concrete: CategoryRepository::class);
        $this->app->bind(abstract: IProductRepository::class, concrete: ProductRepository::class);
        $this->app->bind(abstract: IFeatureRepository::class, concrete: FeatureRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
