<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CartServiceInterface
{
    /**
     * @return string
     */
    public function createEmptyCart(): string;

    public function getCart(string $maskedId): Collection;
}
