<?php
declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\DownloaderInterface;
use App\Interfaces\ExtractorInterface;
use App\Interfaces\UrlFrontierInterface;
use App\Services\Downloader;
use App\Services\Extractor;
use App\Services\UrlFrontier;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DownloaderInterface::class, Downloader::class);
        $this->app->bind(ExtractorInterface::class, Extractor::class);
        $this->app->bind(UrlFrontierInterface::class, UrlFrontier::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
