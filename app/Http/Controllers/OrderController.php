<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateOrderRequest;
use App\Repositories\CategoryRepository;
use App\Services\OrderService;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderDetailRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderService;
    protected $customerRepository;
    protected $categoryRepository;
    protected $orderDetailRepository;

    public function __construct(
        OrderService $orderService,
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        OrderDetailRepository $orderDetailRepository
    )
    {
        $this->orderService = $orderService;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $orders = $this->orderService->searchQuery($query, $request->input());
        foreach ($orders as $k => $order) {
            if (Auth::user()->role == WAREHOUSE_STAFF && in_array($order->status, [DRAFT, AWAITING, REJECTED])) {
                unset($orders[$k]);
            }
        }
//        foreach ($orders as $k => $order) {
//            if ($order->orderDetail->isEmpty()) {
//                $this->orderService->delete($order->id);
//                unset($orders[$k]);
//            }
//        }
        $customers = $this->customerRepository->getList('customer_name');
        return view('order.index', compact('orders', 'customers'));
    }

    public function detail($id)
    {
        $order = $this->orderService->find($id);
        if (Auth::user()->role == WAREHOUSE_STAFF && in_array($order->status, [DRAFT, AWAITING, REJECTED])) {
            return abort(403, 'Unauthorized');
        }
        if (!empty($order->customer_info)) {
            $order->customer = json_decode($order->customer_info);
        }
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
        $data = $request->only([
            'order_number',
            'customer_id',
            'product_id',
            'order_total',
            'order_discount',
            'quantity',
            'unit_price',
            'discount_percent',
            'shipping_address',
            'payment_type',
            'payment_method',
            'note',
            'order_note',
            'bank_customer_name',
            'bank_name',
            'bank_code',
            'delivery-info',
            'is_print_red_invoice',
            'deposit',
            'order_total_product_price',
            'product_price'
        ]);
        $order = $this->orderService->createOrder($data);
        if ($order) {
            return redirect()->route('order.detail', $order->id)->with(
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
        if (Auth::user()->role == WAREHOUSE_STAFF && in_array($order->status, [DRAFT, AWAITING, REJECTED])) {
            return abort(403, 'Unauthorized');
        }
        if (!$order) {
            return redirect()->route('order.index')->with(
                ['flash_level' => 'error', 'flash_message' => 'Đơn hàng không tồn tại']
            );
        }

        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $customers = $this->customerRepository->getList('customer_name');
            $categories = $this->categoryRepository->getList('category_name');
            $discounts = $this->orderService->mapDiscounts();
            return view('order.edit', compact('order', 'customers', 'categories', 'discounts'));
        }

        $data = $request->only([
            'order_number',
            'customer_id',
            'product_id',
            'order_total',
            'order_discount',
            'quantity',
            'unit_price',
            'discount_percent',
            'shipping_address',
            'payment_type',
            'payment_method',
            'note',
            'order_note',
            'bank_customer_name',
            'bank_name',
            'bank_code',
            'delivery-info',
            'is_print_red_invoice',
            'deposit',
            'order_total_product_price',
            'product_price'
        ]);
        $updated = $this->orderService->updateOrder($order->id, $data);
        if ($updated) {
            return redirect()->route('order.detail', $order->id)->with(
                ['flash_level' => 'success', 'flash_message' => 'Cập nhật đơn hàng thành công']
            );
        }

        return redirect()->route('order.edit', $id)->with(
            ['flash_level' => 'error', 'flash_message' => 'Lỗi không thể cập nhật đơn hàng']
        );
    }

    public function delete($id)
    {
        DB::beginTransaction();
        $order = $this->orderService->delete($id, true);
        if ($order && $this->orderDetailRepository->deleteAll('order_id', $id)) {
            DB::commit();
            return redirect()->route('order.index')->with(
                ['flash_level' => 'success', 'flash_message' => 'Xóa thành công']
            );
        }
        DB::rollBack();
        return redirect()->route('order.index')->with(
            ['flash_level' => 'error', 'flash_message' => 'Lỗi không thể xóa đơn hàng']
        );
    }

    public function deleteOrderDetail($orderDetailId)
    {
        $orderDetail = $this->orderDetailRepository->delete($orderDetailId);
        if ($orderDetail) {
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

    public function updateStatusOrder(Request $request, $id, $status)
    {
        $dataUpdate = ['status' => intval($status)];
        if ($request->isMethod('put')) {
            if ($status == CONFIRMED) {
                $order = $this->orderService->find(intval($id));
                $dataUpdate['customer_info'] = json_encode($order->customer);
            }
            if ($this->orderService->update(intval($id), $dataUpdate)) {
                return redirect()->route(Auth::user()->role == WAREHOUSE_STAFF ? 'warehouse-staff.order.index' : 'order.index')->with(
                    ['flash_level' => 'success', 'flash_message' => 'Cập nhật trạng thái đơn hàng thành công']
                );
            }
            return redirect()->route(Auth::user()->role == WAREHOUSE_STAFF ? 'warehouse-staff.order.index' : 'order.index')->with(
                ['flash_level' => 'error', 'flash_message' => 'Cập nhật trạng thái đơn hàng thất bại']
            );
        }
    }

    public function indexPayment(Request $request)
    {
        $query = $request->input('query');
        $orders = $this->orderService->searchQuery($query, $request->input());
//        foreach ($orders as $k => $order) {
//            if ($order->orderDetail->isEmpty()) {
//                $this->orderService->delete($order->id);
//                unset($orders[$k]);
//            }
//        }
        $customers = $this->customerRepository->getList('customer_name');
        return view('payment.indexPayment', compact('orders', 'customers'));
    }

    public function detailPayment($id)
    {
        $order = $this->orderService->find($id);
        if (!empty($order->customer_info)) {
            $order->customer = json_decode($order->customer_info);
        }
        return view('payment.detailPayment', compact('order'));
    }
    public function updatePayment($id)
    {
        $order = $this->orderService->find($id);
        if (!empty($order->customer_info)) {
            $order->customer = json_decode($order->customer_info);
        }
        return view('payment.detailPayment', compact('order'));
    }
}
