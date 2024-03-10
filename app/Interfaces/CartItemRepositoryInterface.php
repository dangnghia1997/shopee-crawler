<?php
declare(strict_types=1);

namespace App\Interfaces;

interface CartItemRepositoryInterface
{
    public function getItems(int $cartId): \Illuminate\Database\Eloquent\Collection;
}
