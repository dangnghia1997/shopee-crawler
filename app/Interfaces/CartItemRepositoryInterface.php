<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Model;

interface CartItemRepositoryInterface
{
    /**
     * @param int $productId
     * @return CartItem|null
     */
    public function getByProductId(int $productId): ?CartItem;

    /**
     * @param int $cartId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItems(int $cartId): \Illuminate\Database\Eloquent\Collection;

    /**
     * @param int $cartId
     * @param CartItem $item
     * @return CartItem
     */
    public function addItemToCart(int $cartId, CartItem $item): CartItem;
}
