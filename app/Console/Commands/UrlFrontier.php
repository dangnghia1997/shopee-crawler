<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Interfaces\UrlFrontierInterface;
use Illuminate\Console\Command;

class UrlFrontier extends Command
{
    /**
     * @var string
     */
    protected $signature = 'shopee:url-frontier {domain}';

    /**
     * @var string
     */
    protected $description = 'Fetching all urls for a single domain';

    public function __construct(
        readonly private UrlFrontierInterface $urlFrontier
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $domain = $this->argument('domain');
        $this->urlFrontier->execute($domain);
    }
}
