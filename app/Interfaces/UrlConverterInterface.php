<?php
declare(strict_types=1);

namespace App\Interfaces;

interface UrlConverterInterface
{
    /**
     * @param string $url
     * @return string|null
     */
    public function execute(string $url): string|null;
}
