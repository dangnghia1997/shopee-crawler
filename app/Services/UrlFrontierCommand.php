<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\CrawlUrlRepositoryInterface;
use App\Interfaces\DownloaderInterface;
use App\Interfaces\UrlConverterInterface;
use App\Interfaces\UrlFrontierCommandInterface;
use Illuminate\Console\Command;

class UrlFrontierCommand implements UrlFrontierCommandInterface
{
    const int MAX_URLS = 50;

    public function __construct(
        readonly private DownloaderInterface $downloader,
        readonly private CrawlUrlRepositoryInterface $crawlUrlRepository,
        readonly private UrlConverterInterface $urlConverter,
    ) {}

    public function execute(Command $console, string $pageUrl): void
    {
        $this->crawlUrlRepository->createTableIfNotExist();
        $counter = 0;

        $url = $this->urlConverter->execute($pageUrl);
        if (!$url) {
            $console->error("Wrong format: " . $pageUrl );
            $console->line('');
            $console->warn("Please use this format: https://tiki.vn/\<urlKey\>/c\<category\>");
            $console->warn("Example: https://tiki.vn/laptop/c8095" );
            return;
        }

        do {
            $console->info("Crawling url:\t" . $url);
            $content = $this->downloader->execute($url);
            if ($content) {
                $this->preProcess($content, $url);
            }

            $url = $this->crawlUrlRepository->getAndPickFirstNonProcessedUrl();
            if ($url && $content) {
                $this->crawlUrlRepository->markAsDone($url);
            }
            $counter++;
            sleep(1);
        } while ($url && $counter < self::MAX_URLS);
    }

    /**
     * @param string $content
     * @param string $url
     * @return void
     */
    protected function preProcess(string $content, string $url): void
    {
        $json = json_decode($content);
        $paging = $json->paging;

        if ($paging->current_page != 1) {
            return;
        }

        $urls = [$url];
        for ($i = 2; $i <= $paging->last_page; $i++) {
            $urls[] = $url . "&page=" . $i;
        }

        if (empty($urls)) {
            return;
        }

        try {
            $this->crawlUrlRepository->insertUrls($urls);
        } catch (\Exception $e) {
            // TODO: Log error
        }
    }
}
