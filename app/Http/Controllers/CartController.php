<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartItemCollection;
use App\Interfaces\CartServiceInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        readonly private CartServiceInterface $cartService,
    ) {}

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createEmptyCart(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => ['cart_id' => $this->cartService->createEmptyCart()]
        ]);
    }

    public function get(string $maskedId): CartResource
    {
        $cart = $this->cartService->getCart($maskedId);
        return new CartResource($cart);
    }

    /**
     * @param AddToCartRequest $request
     * @param string $maskedId
     * @return CartResource
     */
    public function addItems(AddToCartRequest $request, string $maskedId): CartResource
    {
        $this->cartService->addToCart($request, $maskedId);
        return $this->get($maskedId);
    }

    public function update(Request $request)
    {
        // TODO: Do later
        return;
    }

    public function removeItem(Request $request)
    {
        // TODO: Do later
        return;
    }
}
