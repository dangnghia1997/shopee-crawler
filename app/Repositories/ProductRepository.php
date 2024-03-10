<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        readonly private Product $model
    ) {}

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(\Illuminate\Database\Eloquent\Builder $query, int|null $perPage = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if (!$perPage) {
            $perPage = (int)config('api.per_page');
        }

        return $query->paginate($perPage);
    }

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
        $this->model->upsert($data, $checkFields, $updateFields);
    }
}
