<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\DownloaderInterface;

class Downloader implements DownloaderInterface
{
    public function execute(string $url): string
    {
        return "";
    }
}
