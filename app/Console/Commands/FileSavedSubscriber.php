<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Interfaces\PubSubServiceInterface;
use Illuminate\Console\Command;

class FileSavedSubscriber extends Command
{
    const CHANNEL =  'file.saved';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pub-sub:file-saved-subscriber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'File saved subscriber';

    public function __construct(
        readonly PubSubServiceInterface $pubSubService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->pubSubService->subscribe(self::CHANNEL, function ($path) {
            echo $path . 'was saved' . PHP_EOL;
        });
    }
}
