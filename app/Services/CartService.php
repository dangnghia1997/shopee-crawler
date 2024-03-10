<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\AddToCartRequest;
use App\Interfaces\CartItemRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CartServiceInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

class CartService implements CartServiceInterface
{
    public function __construct(
        readonly private CartRepositoryInterface $cartRepository,
        readonly private CartItemRepositoryInterface $cartItemRepository,
        readonly private ProductRepositoryInterface $productRepository,
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

    /**
     * @param string $maskedId
     * @return int
     */
    public function getCartId(string $maskedId): int
    {
        $cart = $this->cartRepository->getCartByMaskedId($maskedId);
        return (int)$cart->id;
    }

    public function addToCart(AddToCartRequest $addToCartRequest, string $maskedId)
    {
        $cartId = $this->getCartId($maskedId);

        $qty = (int)$addToCartRequest->get('qty');
        $productId = (int)$addToCartRequest->get('product_id');
        $product = $this->productRepository->getById(
            (int)$addToCartRequest->get('product_id')
        );

        $existedCartItemWithProductId = $this->cartItemRepository->getByProductId($productId);
        if ($existedCartItemWithProductId) {
            $qty = $qty + (int)$existedCartItemWithProductId->qty;
        };


        $item =  CartItem::factory()->make([
            'product_id' => $product->id,
            'qty' => $qty,
            'price' => $product->price,
            'row_total' => $qty * $product->price,
            'sku' => $product->sku,
            'name' => $product->name,
        ]);

        return $this->cartItemRepository->addItemToCart($cartId, $item);
    }
}
