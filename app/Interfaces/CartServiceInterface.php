<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;

interface CartServiceInterface
{
    /**
     * @return string
     */
    public function createEmptyCart(): string;

    public function getCart(string $maskedId): ?Cart;

    public function addToCart(AddToCartRequest $addToCartRequest, string $maskedId): void;

    /**
     * @param string $maskedId
     * @return void
     */
    public function reCalculate(string $maskedId): void;
}
