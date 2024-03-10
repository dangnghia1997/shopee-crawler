<?php
declare(strict_types=1);

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductServiceInterface;
use App\Models\Product;
use App\ProductSearch\ProductSearch;
use Illuminate\Http\Request;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        readonly private ProductRepositoryInterface $productRepository
    ) {}

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = ProductSearch::apply($request, (new Product())->newQuery());
        $perPage = $request->get('per_page');

        return $this->productRepository->getList($query, (int)$perPage);
    }
}
