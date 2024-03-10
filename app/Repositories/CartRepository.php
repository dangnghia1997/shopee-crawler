<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;

class CartRepository implements CartRepositoryInterface
{
    public function __construct(readonly private Cart $model)
    {}

    public function createEmptyCart(): string
    {
        $model = $this->model::factory()->create();
        return $model->masked_id;
    }

    /**
     * @param string $maskedId
     * @return Cart|null
     */
    public function getCartByMaskedId(string $maskedId): ?Cart
    {
        return $this->model->newQuery()->where('masked_id', '=', $maskedId)->first();
    }
}
