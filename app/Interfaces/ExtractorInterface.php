<?php
declare(strict_types=1);

namespace App\Interfaces;

interface ExtractorInterface
{
    const string DOMAIN = "shopee.vn";

    public function extractInternalLinks(string $body);
}
