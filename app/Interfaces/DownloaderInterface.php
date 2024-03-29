<?php
declare(strict_types=1);

namespace App\Interfaces;

interface DownloaderInterface
{
    /**
     * @param string $url
     * @return string|null
     */
    public function execute(string $url): string | null;
}
