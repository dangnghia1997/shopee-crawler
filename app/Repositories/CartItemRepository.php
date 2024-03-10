<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\CartItemRepositoryInterface;
use App\Models\CartItem;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function __construct(readonly private CartItem $model)
    {}

    public function getItems(int $cartId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->newQuery()->where('cart_id', '=', $cartId)->get();
    }
}
