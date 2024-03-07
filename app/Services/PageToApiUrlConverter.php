<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\UrlConverterInterface;

class PageToApiUrlConverter implements UrlConverterInterface
{
    const string TIKI_API_URL = 'https://tiki.vn/api/personalish/v1/blocks/listings?urlKey=%s&category=%s&limit=40';

    /**
     * @param string $url
     * @return string|null
     */
    public function execute(string $url): string|null
    {
        $parsedUrl = parse_url($url);
        $pattern = '/(\w+)\/c(\d+)/';
        if (preg_match($pattern, $parsedUrl['path'], $matches)) {
            $urlKey = $matches[1];
            $category = $matches[2];
            return sprintf(self::TIKI_API_URL, $urlKey, $category);
        }
        return null;
    }
}
