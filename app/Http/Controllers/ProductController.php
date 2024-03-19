<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct (ProductService $productService, ProductRepository $productRepository) {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    public function getByCategoryId(Request $request)
    {
        $categoryId = intval($request->query('categoryId') ?? 0);
        $productIdNotIn = array_map('intval', $request->query('productIdNotIn') ?? []);
        $products = $this->productService->getByCategoryId($categoryId, $productIdNotIn);
        return response()->json($products);
    }

    public function searchProduct(Request $request)
    {
        $query = $request->query('query') ?? "";
        $products = $this->productService->searchQuery($query, $request->query());
        return response()->json($products);
    }
}
