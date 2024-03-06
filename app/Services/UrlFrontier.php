<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\UrlFrontierInterface;

class UrlFrontier implements UrlFrontierInterface
{

    public function execute(string $domain): void
    {
        echo "FROM SERVICE " . PHP_EOL;
        echo $domain . PHP_EOL;
    }
}
