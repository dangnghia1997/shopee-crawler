<?php
declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\AddToCartRequest;
use App\Interfaces\CartItemRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CartServiceInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Cart;
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

    /**
     * @param string $maskedId
     * @return Cart|null
     */
    public function getCart(string $maskedId): ?Cart
    {
        $cart = $this->cartRepository->getCartByMaskedId($maskedId);
        $cartItems = $this->cartItemRepository->getItems((int)$cart->id);
        $cart->setAttribute('items', $cartItems);
        return $cart;
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

    public function addToCart(AddToCartRequest $addToCartRequest, string $maskedId): void
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

         $this->cartItemRepository->addItemToCart($cartId, $item);
         $this->reCalculate($maskedId);
    }

    /**
     * @param string $maskedId
     * @return void
     */
    public function reCalculate(string $maskedId): void
    {
        $currentCart = $this->cartRepository->getCartByMaskedId($maskedId);
        $items = $this->cartItemRepository->getItems((int)$currentCart->id);

        $itemsCount = 0;
        $grantTotal = 0;

        /** @var CartItem $item */
        foreach ($items as $item) {
            $itemsCount += $item->qty;
            $grantTotal += $item->row_total;
        }

        $currentCart->setAttribute('grant_total', $grantTotal);
        $currentCart->setAttribute('items_count', $itemsCount);

        $currentCart->save();
    }
}
