<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\CartItemRepositoryInterface;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Model;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function __construct(readonly private CartItem $model)
    {}

    /**
     * @param int $productId
     * @return CartItem|null
     */
    public function getByProductId(int $productId): ?CartItem
    {
        return $this->model->newQuery()->where('product_id', '=', $productId)->first();
    }

    /**
     * @param int $cartId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItems(int $cartId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->newQuery()->where('cart_id', '=', $cartId)->get();
    }

    /**
     * @param int $cartId
     * @param CartItem $item
     * @return CartItem
     */
    public function addItemToCart(int $cartId, CartItem $item): CartItem
    {
        $item->setAttribute('cart_id', $cartId);
        $this->model->upsert($item->toArray(), ['product_id'], ['cart_id', 'sku', 'name' ,'qty', 'price', 'row_total']);
        return $item;
    }
}
