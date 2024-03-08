<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\PubSubServiceInterface;
use Illuminate\Support\Facades\Redis;

class RedisPubSubService implements PubSubServiceInterface
{
    /**
     * @param string $channel
     * @param string $message
     * @return void
     */
    public function publish(string $channel, string $message): void
    {
        Redis::publish($channel, $message);
    }

    /**
     * @param string $channel
     * @param \Closure $callback
     * @return void
     */
    public function subscribe(string $channel, \Closure $callback): void
    {
        Redis::subscribe([$channel], function ($message) use ($callback) {
            $callback($message);
        });
    }
}
