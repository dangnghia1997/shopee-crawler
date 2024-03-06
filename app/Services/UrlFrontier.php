<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\DownloaderInterface;
use App\Interfaces\ExtractorInterface;
use App\Interfaces\UrlFrontierInterface;

class UrlFrontier implements UrlFrontierInterface
{
    public function __construct(
        readonly private DownloaderInterface $downloader,
        readonly private ExtractorInterface  $extractor
    ) {}

    public function execute(string $domain): void
    {
        echo "FROM SERVICE " . PHP_EOL;
    }
}
