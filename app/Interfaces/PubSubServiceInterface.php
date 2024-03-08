<?php
declare(strict_types=1);

namespace App\Interfaces;

interface PubSubServiceInterface
{
    /**
     * @param string $channel
     * @param string $message
     * @return void
     */
    public function publish(string $channel, string $message): void;

    /**
     * @param string $channel
     * @param \Closure $callback
     * @return void
     */
    public function subscribe(string $channel, \Closure $callback): void;
}
