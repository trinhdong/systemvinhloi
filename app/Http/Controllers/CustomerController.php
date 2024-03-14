<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateCustomerRequest;
use App\Repositories\AreaRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;
    protected $areaRepository;
    protected $productRepository;
    protected $categoryRepository;

    public function __construct (
        CustomerService $customerService,
        AreaRepository $areaRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->customerService = $customerService;
        $this->areaRepository = $areaRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
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
        return view('customer.detail', compact('customer', 'areas', 'products'));
    }

    public function add(CreateUpdateCustomerRequest  $request)
    {
        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $areas = $this->areaRepository->getList();
            $products = $this->productRepository->getList('product_name');
            $categories = $this->categoryRepository->getList('category_name');
            return view('customer.add', compact('areas', 'products', 'categories'));
        }

        $data = $request->only(['customer_name', 'email', 'phone', 'address', 'area_id', 'product_id', 'discount_percent']);
        dd($data);
        $customer = $this->customerService->createCustomer($data);
        if ($customer) {
            return redirect()->route('customer.index')->with(['flash_level' => 'success', 'flash_message' => 'Thêm khách hàng thành công']);
        }

        return redirect()->route('customer.add')->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể thêm khách hàng']);
    }

    public function edit(CreateUpdateCustomerRequest $request, $id)
    {
        $customer = $this->customerService->find($id);
        if (!$customer) {
            return redirect()->route('customer.index')->with(['flash_level' => 'error', 'flash_message' => 'Khách hàng không tồn tại']);
        }

        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $products = $this->productRepository->getList('product_name');
            $areas = $this->areaRepository->getList();
            $categories = $this->categoryRepository->getList('category_name');
            return view('customer.edit', compact('customer', 'areas', 'products', 'categories'));
        }

        $data = $request->only(['customer_name', 'email', 'phone', 'address', 'area_id']);
        $updated = $this->customerService->updateCustomer($customer->id, $data);
        if ($updated) {
            return redirect()->route('customer.index')->with(['flash_level' => 'success', 'flash_message' => 'Cập nhật khách hàng thành công']);
        }

        return redirect()->route('customer.edit')->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể cập nhật khách hàng']);
    }

    public function delete($id)
    {
        $customer = $this->customerService->delete($id);
        if ($customer) {
            return redirect()->route('customer.index')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        return redirect()->route('customer.index')->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể xóa khách hàng']);
    }
}
