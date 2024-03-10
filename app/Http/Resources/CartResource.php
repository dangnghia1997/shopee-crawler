<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cart_id' => $this->masked_id,
            'grant_total' => $this->grant_total,
            'items_count' => $this->items_count,
            'items' => new CartItemCollection($this->items)
        ];
    }
}
