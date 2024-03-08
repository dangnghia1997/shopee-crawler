<?php
declare(strict_types=1);

namespace App\Interfaces;

interface PubSubServiceInterface
{
    public function publish(string $channel, string $message): void;
    public function subscribe(string $channel, \Closure $callback): void;

}
