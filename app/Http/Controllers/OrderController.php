<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateOrderRequest;
use App\Repositories\CategoryRepository;
use App\Services\OrderService;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    protected $customerRepository;
    protected $categoryRepository;

    public function __construct(
        OrderService $orderService,
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->orderService = $orderService;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $orders = $this->orderService->searchQuery($query, $request->input());
        $customers = $this->customerRepository->getList('customer_name');
        return view('order.index', compact('orders', 'customers'));
    }

    public function detail($id)
    {
        $order = $this->orderService->find($id);
        return view('order.detail', compact('order'));
    }

    public function add(CreateUpdateOrderRequest $request)
    {
        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $customers = $this->customerRepository->getList('customer_name');
            $categories = $this->categoryRepository->getList('category_name');
            $discounts = $this->orderService->mapDiscounts();
            return view('order.add', compact('customers', 'categories', 'discounts'));
        }
        $data = $request->only(['order_number', 'customer_id', 'product_id', 'order_total', 'order_discount', 'quantity', 'unit_price']);
        $order = $this->orderService->createOrder($data);
        if ($order) {
            return redirect()->route('order.index')->with(
                ['flash_level' => 'success', 'flash_message' => 'Thêm đơn hàng thành công']
            );
        }

        return redirect()->route('order.add')->with(
            ['flash_level' => 'error', 'flash_message' => 'Lỗi không thể thêm đơn hàng']
        );
    }

    public function edit(CreateUpdateOrderRequest $request, $id)
    {
        $order = $this->orderService->find($id);
        if (!$order) {
            return redirect()->route('order.index')->with(
                ['flash_level' => 'error', 'flash_message' => 'Đơn hàng không tồn tại']
            );
        }

        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            return view('order.edit', compact('order'));
        }

        $data = $request->only(['name', 'email', 'password', 'role']);
        $updated = $this->orderService->updateUser($order->id, $data);
        if ($updated) {
            return redirect()->route('order.index')->with(
                ['flash_level' => 'success', 'flash_message' => 'Cập nhật đơn hàng thành công']
            );
        }

        return redirect()->route('order.edit')->with(
            ['flash_level' => 'error', 'flash_message' => 'Lỗi không thể cập nhật đơn hàng']
        );
    }

    public function delete($id)
    {
        $order = $this->orderService->delete($id);
        if ($order) {
            return redirect()->route('order.index')->with(
                ['flash_level' => 'success', 'flash_message' => 'Xóa thành công']
            );
        }
        return redirect()->route('order.index')->with(
            ['flash_level' => 'error', 'flash_message' => 'Lỗi không thể xóa đơn hàng']
        );
    }
}
