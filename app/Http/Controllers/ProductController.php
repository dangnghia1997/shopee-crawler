<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        readonly private ProductServiceInterface $productService
    ) {}

    public function search(Request $request)
    {
        return $this->productService->search($request);
    }
}
