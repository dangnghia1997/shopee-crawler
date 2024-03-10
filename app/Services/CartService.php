<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\CartItemRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CartServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class CartService implements CartServiceInterface
{
    public function __construct(
        readonly private CartRepositoryInterface $cartRepository,
        readonly private CartItemRepositoryInterface $cartItemRepository,
    ) {}

    /**
     * @return string
     */
    public function createEmptyCart(): string
    {
        return $this->cartRepository->createEmptyCart();
    }

    public function getCart(string $maskedId): Collection
    {
        $cart = $this->cartRepository->getCartByMaskedId($maskedId);
        return $this->cartItemRepository->getItems((int)$cart->id);
    }
}
