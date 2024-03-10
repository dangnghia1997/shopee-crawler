<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(\Illuminate\Database\Eloquent\Builder $query, int|null $perPage = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * @param Model $object
     * @return void
     */
    public function save(Model $object): void;

    /**
     * @param array $data
     * @param array $checkFields
     * @param array $updateFields
     * @return void
     */
    public function upsert(array $data, array $checkFields = [], array $updateFields = []): void;
}
