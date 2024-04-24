<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateCustomerRequest;
use App\Repositories\AreaRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\DiscountRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderRepository;
use App\Services\CustomerService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $customerService;
    protected $areaRepository;
    protected $productRepository;
    protected $categoryRepository;
    protected $discountRepository;
    protected $customerRepository;
    protected $productService;
    protected $orderRepository;

    public function __construct(
        CustomerService $customerService,
        AreaRepository $areaRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        DiscountRepository $discountRepository,
        CustomerRepository $customerRepository,
        ProductService $productService,
        OrderRepository $orderRepository
    ) {
        $this->customerService = $customerService;
        $this->areaRepository = $areaRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->discountRepository = $discountRepository;
        $this->customerRepository = $customerRepository;
        $this->productService = $productService;
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        $areas = $this->areaRepository->getList();
        $categories = $this->categoryRepository->getList('category_name');
        $query = $request->input('query');
        $customers = $this->customerService->searchQuery($query, $request->input());
        return view('customer.index', compact('customers', 'areas', 'categories'));
    }

    public function detail($id)
    {
        $areas = $this->areaRepository->getList();
        $products = $this->productRepository->getList('product_name');
        $customer = $this->customerService->find($id);
        $categories = $this->categoryRepository->getList('category_name');
        $categoryIds = $this->productRepository->getList('category_id');
        $productPrice = $this->productRepository->getList('price');
        $discounts = $customer->discount;
        return view(
            'customer.detail',
            compact('customer', 'areas', 'products', 'categories', 'productPrice', 'categoryIds', 'discounts')
        );
    }

    public function add(CreateUpdateCustomerRequest $request)
    {
        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $areas = $this->areaRepository->getList();
            $categories = $this->categoryRepository->getList('category_name');
            return view('customer.add', compact('areas', 'categories'));
        }

        $data = $request->only(
            ['customer_name', 'email', 'phone', 'address', 'area_id', 'product_id', 'discount_percent', 'discount_price', 'tax_code', 'company', 'company_address', 'note']
        );
        $customer = $this->customerService->createCustomer($data);
        if ($customer) {
            return redirect()->route('customer.index')->with(
                ['flash_level' => 'success', 'flash_message' => 'Thêm khách hàng thành công']
            );
        }

        return redirect()->route('customer.add')->with(
            ['flash_level' => 'error', 'flash_message' => 'Lỗi không thể thêm khách hàng']
        );
    }

    public function edit(CreateUpdateCustomerRequest $request, $id)
    {
        $customer = $this->customerService->find($id);
        if (!$customer) {
            return redirect()->route('customer.index')->with(
                ['flash_level' => 'error', 'flash_message' => 'Khách hàng không tồn tại']
            );
        }

        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $products = $this->productRepository->getList('product_name');
            $areas = $this->areaRepository->getList();
            $categories = $this->categoryRepository->getList('category_name');
            $categoryIds = $this->productRepository->getList('category_id');
            $productPrice = $this->productRepository->getList('price');
            return view(
                'customer.edit',
                compact('customer', 'areas', 'products', 'categories', 'categoryIds', 'productPrice')
            );
        }

        $data = $request->only(
            ['customer_name', 'email', 'phone', 'address', 'area_id', 'product_id', 'discount_percent', 'discount_price', 'tax_code', 'company', 'company_address', 'note']
        );
        $updated = $this->customerService->updateCustomer($customer->id, $data);
        if ($updated) {
            return redirect()->route('customer.index')->with(
                ['flash_level' => 'success', 'flash_message' => 'Cập nhật khách hàng thành công']
            );
        }

        return redirect()->route('customer.edit', $id)->with(
            ['flash_level' => 'error', 'flash_message' => 'Lỗi không thể cập nhật khách hàng']
        );
    }

    public function delete($id)
    {
        DB::beginTransaction();
        $customer = $this->customerRepository->delete($id, true);
        if ($customer) {
            $hasDiscounts = $this->discountRepository->getWhere(['customer_id' => $id])->count() > 0;
            if ($hasDiscounts) {
                $this->discountRepository->deleteAll('customer_id', $id);
            }
            DB::commit();
            return redirect()->route('customer.index')->with(
                ['flash_level' => 'success', 'flash_message' => 'Xóa thành công']
            );
        }
        DB::rollBack();
        return redirect()->route('customer.index')->with(
            ['flash_level' => 'error', 'flash_message' => 'Lỗi không thể xóa khách hàng']
        );
    }

    public function deleteDiscount($discountId)
    {
        $discount = $this->discountRepository->delete($discountId);
        if ($discount) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Xóa không thành công',
        ]);
    }
    public function getCustomerInfo($id)
    {
        $customer = $this->customerRepository->getWhere(['id' => $id])->first();
        return response()->json($customer);
    }
    public function searchProduct(Request $request)
    {
        $query = $request->query('query') ?? "";
        $products = $this->productService->searchProduct($query, $request->query());
        foreach ($products as &$product) {
            foreach ($product['category']['product'] ?? [] as &$p) {
                $p = json_encode($p);
            }
            $product['category'] = json_encode($product['category']);
        }
        return response()->json($products);
    }
}
