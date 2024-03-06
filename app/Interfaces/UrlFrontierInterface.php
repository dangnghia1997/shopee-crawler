<?php
declare(strict_types=1);

namespace App\Interfaces;

interface UrlFrontierInterface
{
    public function execute(string $domain): void;
}
