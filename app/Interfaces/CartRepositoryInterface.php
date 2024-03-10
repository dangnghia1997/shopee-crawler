<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Cart;

interface CartRepositoryInterface
{
    /**
     * @return string
     */
    public function createEmptyCart(): string;

    /**
     * @param string $maskedId
     * @return Cart|null
     */
    public function getCartByMaskedId(string $maskedId): ?Cart;
}
