<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    public function __construct (ProductService $productService, CategoryService $categoryService) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
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
    public function index(Request $request)
    {
        $searchTerm = $request->query('search-area', '');
        $filters = [];
        if (!empty($searchTerm)) {
            $filters['whereRaw'] = "product_name LIKE '%" . $searchTerm . "%'";
        }
        $productList = $this->productService->paginate($filters, '', 'ASC', 20, false);
        return view('product.index', compact('productList'));
    }
    public function show()
    {
        $categoryList = $this->categoryService->getAll();
        return view('product.add', compact('categoryList'));
    }
}
