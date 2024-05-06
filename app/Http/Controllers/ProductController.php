<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $categoryRepository;
    public function __construct (ProductService $productService, CategoryService $categoryService, CategoryRepository $categoryRepository) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
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
        $query = $request->input('query');
        $productList = $this->productService->searchQuery($query, $request->query());
        $categories = $this->categoryRepository->getList('category_name');
        return view('product.index', compact('productList', 'categories'));
    }
    public function show()
    {
        $categoryList = $this->categoryService->getAll();
        return view('product.add', compact('categoryList'));
    }
    public function create(CreateProductRequest $request)
    {
        $insertProduct = $this->productService->storeProductService($request);
        if ($insertProduct) {
            return redirect()->route('product.list')->with(['flash_level' => 'success', 'flash_message' => 'Thêm sản phẩm thành công']);
        } else {
            return redirect()->back()->withInput()->with(['flash_level' => 'error', 'flash_message' => 'Thêm sản phẩm không thành công']);
        }
    }
    public function detail($id)
    {
        $categoryList = $this->categoryService->getAll();
        $product = $this->productService->find($id);
        return view('product.detail', compact('product', 'categoryList'));
    }
    public function edit($id)
    {
        $categoryList = $this->categoryService->getAll();
        $product = $this->productService->find($id);
        return view('product.edit', compact('product', 'categoryList'));
    }

    public function update(UpdateProductRequest $request)
    {
         $updateProduct = $this->productService->updateProductService($request);
        if ($updateProduct) {
            return redirect()->route('product.list')->with(['flash_level' => 'success', 'flash_message' => 'Chỉnh sửa sản phẩm thành công']);
        } else {
            return redirect()->back()->withInput()->with(['flash_level' => 'error', 'flash_message' => 'Chỉnh sửa sản phẩm không thành công']);
        }
    }
    public function delete($id)
    {
        try {
            $product = $this->productService->find($id);
            if (!$product) {
                return redirect()->route('product.list')->with([
                    'flash_level' => 'error',
                    'flash_message' => 'Sản phẩm không tồn tại.'
                ]);
            }
            $product->deleted_by = auth()->user()->id;
            $product->delete();

            return redirect()->route('product.list')->with([
                'flash_level' => 'success',
                'flash_message' => 'Xóa sản phẩm thành công.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('product.list')->with([
                'flash_level' => 'error',
                'flash_message' => 'Đã có lỗi xảy ra khi xóa sản phẩm.'
            ]);
        }
    }
}
