<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\ExtractorInterface;

class Extractor implements ExtractorInterface
{
    public function extractInternalLinks(string $body): array
    {
        $links = $this->extractHrefAttribute($body);

        $internalLinks = [];
        $domain = self::DOMAIN;

        foreach ($links as $link) {
            $parsedLink = parse_url($link);
            if (isset($parsedLink['host']) && $parsedLink['host'] != $domain) {
                //those are external links, do nothing
            } else {
                if (isset($parsedLink['host']) && isset($parsedLink['path']) && $parsedLink['path'] != "/" && $this->isPaginationPath($parsedLink['path'])) {
                    $internalLinks[] = $parsedLink['host'] . $parsedLink['path'];
                }
                if (substr($link, 0, 1) === "/" && $link != "/" && $this->isPaginationPath($link)) {
                    $internalLinks[] = $domain . $link;
                }
            }
        }
        return array_unique($internalLinks);
    }


    /**
     * @param string $body
     * @return string[]
     */
    protected function extractHrefAttribute(string $body): array
    {
        $dom = new \DOMDocument;

        @$dom->loadHTML($body);
        $links = $dom->getElementsByTagName('a');

        $linkArray = [];

        foreach ($links as $link) {
            $linkArray[] = $link->getAttribute('href');
        }
        return array_unique($linkArray);
    }

    protected function isPaginationPath(string $path): bool
    {
        $pattern = "/Máy-Tính-Laptop-cat.11035954/";
        return preg_match($pattern, $path);
    }
}
