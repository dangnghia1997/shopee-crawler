<?php
declare(strict_types=1);

namespace App\Interfaces;

interface CrawlUrlRepositoryInterface
{
    const  TBL_NAME = "crawl_urls";

    /**
     * @return string
     */
    public function getTableName(): string;

    /**
     * @return void
     */
    public function createTableIfNotExist(): void;

    /**
     * @return string|null
     */
    public function getAndPickFirstNonProcessedUrl(): string | null;

    /**
     * @param string $url
     * @return void
     */
    public function markAsDone(string $url): void;

    /**
     * @param array|string[] $urls
     * @return void
     */
    public function insertUrls(array $urls): void;
}
