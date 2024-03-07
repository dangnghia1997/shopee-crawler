<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Console\Command;

interface UrlFrontierCommandInterface
{
    /**
     * @param Command $console
     * @param string $pageUrl
     * @return void
     */
    public function execute(Command $console, string $pageUrl): void;
}
