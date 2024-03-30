<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateOrderRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Services\OrderService;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderService;
    protected $customerRepository;
    protected $categoryRepository;
    protected $orderDetailRepository;
    protected $commentRepository;
    protected $userRepository;

    public function __construct(
        OrderService $orderService,
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        OrderDetailRepository $orderDetailRepository,
        CommentRepository $commentRepository,
        UserRepository $userRepository
    )
    {
        $this->orderService = $orderService;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $input = $request->input();
        $statusList = STATUS_ORDER;
        $paymentStatus = STATUS_PAYMENT;
        if (Auth::user()->role == WAREHOUSE_STAFF) {
            $input['status_not_in'] = [
                DRAFT, AWAITING
            ];
            unset($statusList[DRAFT]);
            unset($statusList[AWAITING]);
        }
        if (Auth::user()->role == ACCOUNTANT) {
            $input['status_not_in'] = [
                DRAFT
            ];
            unset($statusList[DRAFT]);
        }
        $orders = $this->orderService->searchQuery($query, $input);
//        foreach ($orders as $k => $order) {
//            if ($order->orderDetail->isEmpty()) {
//                $this->orderService->delete($order->id);
//                unset($orders[$k]);
//            }
//        }
        $customers = $this->customerRepository->getList('customer_name');
        $isAdmin = Auth::user()->role == ADMIN || Auth::user()->role == SUPER_ADMIN;
        $isSale =  Auth::user()->role == SALE;
        $isWareHouseStaff = Auth::user()->role == WAREHOUSE_STAFF;
        $isAccountant =  Auth::user()->role == ACCOUNTANT;
        return view('order.index', compact('orders', 'customers', 'statusList', 'paymentStatus', 'isAdmin', 'isSale', 'isWareHouseStaff', 'isAccountant'));
    }

    public function detail($id)
    {
        $order = $this->orderService->find($id);
        if (Auth::user()->role == WAREHOUSE_STAFF && in_array($order->status, [DRAFT, AWAITING])) {
            return abort(403, 'Unauthorized');
        }
        if (Auth::user()->role == ACCOUNTANT && in_array($order->status, [DRAFT])) {
            return abort(403, 'Unauthorized');
        }
        if (!empty($order->customer_info)) {
            $order->customer = json_decode($order->customer_info);
        }
        $comments = $this->commentRepository->getWhere([
            'order_id' => $id,
            'type' => COMMENT_TYPE_ORDER
        ]);
        $users = $this->userRepository->getList('name');
        $isAdmin = Auth::user()->role == ADMIN || Auth::user()->role == SUPER_ADMIN;
        $isSale =  Auth::user()->role == SALE;
        $isWareHouseStaff = Auth::user()->role == WAREHOUSE_STAFF;
        $isAccountant =  Auth::user()->role == ACCOUNTANT;
        return view('order.detail', compact('order', 'comments', 'users', 'isAdmin', 'isSale', 'isWareHouseStaff', 'isAccountant'));
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
        $msg = '';
        $order = $this->orderService->createOrder($data, $msg);
        if ($order) {
            return redirect()->route('order.detail', $order->id)->with(
                ['flash_level' => 'success', 'flash_message' => 'Thêm đơn hàng thành công']
            );
        }

        return redirect()->route('order.add')->with(
            ['flash_level' => 'error', 'flash_message' => $msg !== '' ? $msg : 'Lỗi không thể thêm đơn hàng']
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
        $msg = '';
        $updated = $this->orderService->updateOrder($order->id, $data, $msg);
        if ($updated) {
            return redirect()->route('order.detail', $order->id)->with(
                ['flash_level' => 'success', 'flash_message' => 'Cập nhật đơn hàng thành công']
            );
        }

        return redirect()->route('order.edit', $id)->with(
            ['flash_level' => 'error', 'flash_message' => $msg !== '' ? $msg : 'Lỗi không thể cập nhật đơn hàng']
        );
    }

    public function delete($id)
    {
        DB::beginTransaction();
        $order = $this->orderService->delete($id, true);
        if ($order && $this->orderDetailRepository->deleteAll('order_id', $id) && $this->commentRepository->deleteAll('order_id', $id)) {
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

    public function updateStatusOrder(Request $request, $id, $status = null)
    {
        $order = $this->orderService->find(intval($id));
        $isSale = Auth::user()->role == SALE;
        $isAdmin = Auth::user()->role == SUPER_ADMIN || Auth::user()->role == ADMIN;
        $isWareHouseStaff = Auth::user()->role == WAREHOUSE_STAFF;
        $dataUpdate = [];
        if ($request->isMethod('put') && $order) {
            if (($isAdmin || $isSale) && ($order->status == DRAFT || $order->status == REJECTED)) {
                $dataUpdate['status'] = $order->payment_type == PAYMENT_ON_DELIVERY ? CONFIRMED : AWAITING;
                if ($dataUpdate['status'] == CONFIRMED) {
                    $dataUpdate['customer_info'] = json_encode($order->customer);
                }
            }
            if (($isAdmin || $isWareHouseStaff) && $order->status == CONFIRMED) {
                $dataUpdate['status'] = DELIVERY;
            }
            if (($isAdmin || $isWareHouseStaff) && $order->status == DELIVERY) {
                $dataUpdate['status'] = DELIVERED;
            }
            if (($isAdmin || $isWareHouseStaff) && isset($status) && $status == REJECTED) {
                $dataUpdate = ['status' => REJECTED];
            }
            if (!empty($dataUpdate['status']) && $this->orderService->update(intval($id), $dataUpdate)) {
//                if (!empty($request->input('note'))) {
                    $this->commentRepository->create([
                        'order_id' => intval($id),
                        'type' => COMMENT_TYPE_ORDER,
                        'status' => $dataUpdate['status'],
                        'note' => $request->input('note') ?? ''
                    ]);
//                }
                return redirect()->route($isWareHouseStaff ? 'warehouse-staff.order.detail' : 'order.detail', $id)->with(
                    ['flash_level' => 'success', 'flash_message' => 'Cập nhật trạng thái đơn hàng thành công']
                );
            }
        }
        return redirect()->route($isWareHouseStaff ? 'warehouse-staff.order.detail' : 'order.detail', $id)->with(
            ['flash_level' => 'error', 'flash_message' => 'Cập nhật trạng thái đơn hàng thất bại']
        );
    }

    public function indexPayment(Request $request)
    {
        $statusList = STATUS_ORDER;
        $statusPayment = STATUS_PAYMENT;
        $query = $request->input('query');
        $input = $request->input();
        $input['status_not_in'] = [DRAFT];
        unset($statusList[DRAFT]);
        $orders = $this->orderService->searchQuery($query, $input);
//        foreach ($orders as $k => $order) {
//            if ($order->orderDetail->isEmpty()) {
//                $this->orderService->delete($order->id);
//                unset($orders[$k]);
//            }
//        }
        $customers = $this->customerRepository->getList('customer_name');
        return view('payment.indexPayment', compact('orders', 'customers', 'statusPayment', 'statusList'));
    }

    public function detailPayment($id)
    {
        $order = $this->orderService->find($id);
        if (in_array($order->status, [DRAFT])) {
            return abort(403, 'Unauthorized');
        }
        if (!empty($order->customer_info)) {
            $order->customer = json_decode($order->customer_info);
        }
        $comments = $this->commentRepository->getWhere([
            'order_id' => $id,
            'type' => COMMENT_TYPE_PAYMENT
        ]);
        $commentOrders = $this->commentRepository->getWhere([
            'order_id' => $id,
            'type' => COMMENT_TYPE_ORDER
        ]);
        if ($order->paid == null) {
            $order->paid = !empty($order->deposit) ? $order->deposit : $order->order_total;
        }
        if ($order->payment_type == PAYMENT_ON_DELIVERY && in_array($order->status, [CONFIRMED, DELIVERY, REJECTED])) {
            $order->paid = null;
        }
        $users = $this->userRepository->getList('name');
        $isAccountant = Auth::user()->role == ACCOUNTANT;
        $isAdmin = Auth::user()->role == SUPER_ADMIN || Auth::user()->role == ADMIN;
        return view('payment.detailPayment', compact('order', 'users', 'comments', 'isAdmin', 'isAccountant', 'commentOrders'));
    }
    public function updateStatusPayment(Request $request, $id, $status = null)
    {
        $order = $this->orderService->find(intval($id));
        $paid = str_replace(',', '', $request->input('paid') ?? '');
        $dayPaid = \DateTime::createFromFormat('d/m/Y', $request->input('payment_date'));
        if ($status == null && ($paid == '' || !$dayPaid)
            && !($order->status == DELIVERED && $order->payment_status == PAID)
            && !($order->payment_status == UNPAID && $order->payment_type == PAYMENT_ON_DELIVERY && in_array($order->status, [CONFIRMED, DELIVERY, REJECTED]))
        ) {
            return redirect()->route('payment.detailPayment', $id)->with(
                ['flash_level' => 'error', 'flash_message' => $paid == '' ? 'Vui lòng nhập số tiền đã thanh toán' : 'Vui lòng nhập ngày thanh toán']
            );
        }

        $dataUpdate = ['paid' => floatval($paid)];
        if ($dayPaid) {
            $dataUpdate['payment_date'] = $dayPaid->format(FORMAT_DATE);
        }
        if ($request->isMethod('put')) {
            $order = $this->orderService->updateStatusPayment(intval($id), $order, $dataUpdate, $status);
            if ($order) {
//                if (!empty($request->input('note'))) {
                    if (!empty($dataUpdate['status'])) {
                        $this->commentRepository->create([
                            'order_id' => intval($id),
                            'type' => COMMENT_TYPE_ORDER,
                            'status' => $order->status,
                            'note' => $request->input('note') ?? ''
                        ]);
                    }
                    $this->commentRepository->create([
                        'order_id' => intval($id),
                        'type' => COMMENT_TYPE_PAYMENT,
                        'status' => $order->payment_status,
                        'note' => $request->input('note') ?? ''
                    ]);
//                }
                return redirect()->route('payment.detailPayment', $id)->with(
                    ['flash_level' => 'success', 'flash_message' => 'Cập nhật trạng thái thanh toán thành công']
                );
            }
        }
        return redirect()->route('payment.detailPayment', $id)->with(
            ['flash_level' => 'error', 'flash_message' => 'Cập nhật trạng thái thanh toán thất bại']
        );
    }

    public function getDiscountByCustomerId(Request $request)
    {
        $customerId = intval($request->query('customerId') ?? 0);
        $productIdsNotIn = array_map('intval', $request->query('productIdsNotIn') ?? []);
        $discounts = $this->orderService->getDiscountByCustomerId($customerId, $productIdsNotIn);
        $products = [];
        foreach ($discounts as $discount) {
            $products[] = $discount->product;
        }
        return response()->json($products);
    }
}
