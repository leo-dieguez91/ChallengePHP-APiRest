<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\GiphyApiInterfaceRepository;
use App\Interfaces\Repositories\GiphyDatabaseInterfaceRepository;
use App\Repositories\GiphyApiRepository;
use App\Repositories\GiphyDatabaseRepository;
use App\Interfaces\Services\GiphySearchInterfaceService;
use App\Interfaces\Services\GiphyShowInterfaceService;
use App\Interfaces\Services\GiphyFavoriteInterfaceService;
use App\Services\GiphySearchService;
use App\Services\GiphyShowService;
use App\Services\GiphyFavoriteService;

class GiphyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register Repositories
        $this->app->bind(GiphyApiInterfaceRepository::class, GiphyApiRepository::class);
        $this->app->bind(GiphyDatabaseInterfaceRepository::class, GiphyDatabaseRepository::class);

        // Register Services
        $this->app->bind(GiphySearchInterfaceService::class, GiphySearchService::class);
        $this->app->bind(GiphyShowInterfaceService::class, GiphyShowService::class);
        $this->app->bind(GiphyFavoriteInterfaceService::class, GiphyFavoriteService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
