<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductRepositoryInterface
{
    public function save(Model $object): void
    {
        try {
            $object->save();
        } catch (\Exception $e) {
            // TODO: Logging
            echo $e;
        }
    }

    /**
     * @param array $data
     * @param array $checkFields
     * @param array $updateFields
     * @return void
     */
    public function upsert(array $data, array $checkFields = [], array $updateFields = []): void
    {
        Product::upsert($data, $checkFields, $updateFields);
    }
}
