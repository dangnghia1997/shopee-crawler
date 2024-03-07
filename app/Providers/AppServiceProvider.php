<?php
declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\CrawlUrlRepositoryInterface;
use App\Interfaces\DownloaderInterface;
use App\Interfaces\UrlConverterInterface;
use App\Interfaces\UrlFrontierCommandInterface;
use App\Repositories\CrawlUrlRepository;
use App\Services\PageToApiUrlConverter;
use App\Services\UrlFrontierCommand;
use App\Services\Downloader;
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

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
