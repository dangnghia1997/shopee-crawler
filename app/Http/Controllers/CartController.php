<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\CartRepositoryInterface;
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
        return response()->json(['cart_id' => $this->cartService->createEmptyCart()]);
    }

    public function get(string $maskedId): \Illuminate\Http\JsonResponse
    {

        return response()->json([
            'data' => $this->cartService->getCart($maskedId)
        ]);
    }

    public function update(Request $request)
    {

    }

    public function removeItem(Request $request)
    {

    }
}
