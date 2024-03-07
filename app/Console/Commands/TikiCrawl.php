<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Interfaces\UrlFrontierCommandInterface;
use Illuminate\Console\Command;

class TikiCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tiki:crawl {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching tiki url';

    public function __construct(
        readonly private UrlFrontierCommandInterface $urlFrontier
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $url = $this->argument('url');
        $this->urlFrontier->execute($this, $url);
    }
}
