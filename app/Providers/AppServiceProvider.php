<?php
declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\CrawlUrlRepositoryInterface;
use App\Interfaces\DownloaderInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\PubSubServiceInterface;
use App\Interfaces\UrlConverterInterface;
use App\Interfaces\UrlFrontierCommandInterface;
use App\Repositories\CrawlUrlRepository;
use App\Repositories\ProductRepository;
use App\Services\PageToApiUrlConverter;
use App\Services\RedisPubSubService;
use App\Services\UrlFrontierCommand;
use App\Services\Downloader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DownloaderInterface::class, Downloader::class);
        $this->app->bind(UrlFrontierCommandInterface::class, UrlFrontierCommand::class);
        $this->app->bind(CrawlUrlRepositoryInterface::class, CrawlUrlRepository::class);
        $this->app->bind(UrlConverterInterface::class, PageToApiUrlConverter::class);
        $this->app->bind(PubSubServiceInterface::class, RedisPubSubService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function ($query) {
            // $query->sql;
            // $query->bindings;
            // $query->time;
        });
    }
}
