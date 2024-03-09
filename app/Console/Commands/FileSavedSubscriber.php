<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\PubSubServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileSavedSubscriber extends Command
{
    const string CHANNEL = 'file.saved';

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
        readonly PubSubServiceInterface $pubSubService,
        readonly ProductRepositoryInterface $productRepository
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->pubSubService->subscribe(self::CHANNEL, function ($path) {
            if (!Storage::exists($path)) {
                echo $path . " is not exists" . PHP_EOL;
                return;
            }
            $this->info("Loading data from $path file and saving products");
            $contents = Storage::get($path);
            $products = json_decode($contents);
            $data = array_map(function ($product) {
                return [
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'thumbnail' => $product->thumbnail_url,
                    'price' => $product->price,
                    'brand_name' => $product->brand_name,
                    'brand_key' => Str::snake(Str::lower($product->brand_name)),
                    'sold' => $product->quantity_sold?->value ?? 0
                ];
            }, $products);

            $this->productRepository->upsert(
                $data,
                ['sku'],
                ['name', 'price', 'brand_name', 'thumbnail', 'brand_key', 'sold']
            );
        });
    }
}
