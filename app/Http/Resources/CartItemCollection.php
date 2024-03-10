<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'item_id' => $item->id,
                    'sku' => $item->sku,
                    'name' => $item->name,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'row_total' => $item->row_total
                ];
            })
        ];
    }
}
