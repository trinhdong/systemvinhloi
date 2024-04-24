<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateOrderRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Services\OrderService;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\CommentRepository;
use App\Repositories\BankAccountRepository;
use App\Repositories\InvoiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    protected $orderService;
    protected $customerRepository;
    protected $categoryRepository;
    protected $orderDetailRepository;
    protected $commentRepository;
    protected $userRepository;
    protected $bankAccountRepository;
    protected $invoiceRepository;

    public function __construct(
        OrderService $orderService,
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        OrderDetailRepository $orderDetailRepository,
        CommentRepository $commentRepository,
        UserRepository $userRepository,
        BankAccountRepository $bankAccountRepository,
        InvoiceRepository $invoiceRepository,
    )
    {
        $this->orderService = $orderService;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->bankAccountRepository = $bankAccountRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $input = $request->input();
        $statusList = STATUS_ORDER;
        $paymentStatus = STATUS_PAYMENT;
        $isAdmin = Auth::user()->role == ADMIN || Auth::user()->role == SUPER_ADMIN;
        $isSale =  Auth::user()->role == SALE;
        $isWareHouseStaff = Auth::user()->role == WAREHOUSE_STAFF;
        $isStocker = Auth::user()->role == STOCKER;
        $isAccountant =  Auth::user()->role == ACCOUNTANT;
        if ($isStocker) {
            $input['status_not_in'] = [DRAFT];
            unset($statusList[DRAFT]);
        }
        if ($isAccountant) {
            $input['status_not_in'] = [DRAFT, DELIVERY, REJECTED, IN_PROCESSING];
            unset($statusList[DRAFT]);
            unset($statusList[DELIVERY]);
            unset($statusList[REJECTED]);
            unset($statusList[IN_PROCESSING]);
        }
        if ($isWareHouseStaff) {
            $input['status_not_in'] = [DRAFT, DELIVERY, DELIVERED, COMPLETE, REJECTED];
            unset($statusList[DRAFT]);
            unset($statusList[DELIVERY]);
            unset($statusList[DELIVERED]);
            unset($statusList[COMPLETE]);
            unset($statusList[REJECTED]);
        }
        $orders = $this->orderService->searchQuery($query, $input, $isSale);
        $customers = $this->customerRepository->getList('customer_name');
        $sales = $this->userRepository->getWhere(['role' => SALE])->pluck('name', 'id');
        return view('order.index', compact('orders', 'customers', 'statusList', 'paymentStatus', 'isAdmin', 'isSale', 'isWareHouseStaff', 'isAccountant', 'isStocker', 'sales'));
    }

    public function detail(int $id)
    {
        $order = $this->orderService->find($id);
        if (Auth::user()->role == STOCKER && $order->status === DRAFT) {
            return abort(403, 'Unauthorized');
        }
        if (Auth::user()->role == ACCOUNTANT && $order->status === [DRAFT, DELIVERY, REJECTED, IN_PROCESSING]) {
            return abort(403, 'Unauthorized');
        }
        if (Auth::user()->role == WAREHOUSE_STAFF && in_array($order->status, [DRAFT, DELIVERY, DELIVERED, COMPLETE, REJECTED])) {
            return abort(403, 'Unauthorized');
        }
        $order = $this->orderService->replaceOrderDataInfo($order);
        $comments = $this->commentRepository->getWhere([
            'order_id' => $id,
            'type' => COMMENT_TYPE_ORDER
        ]);
        $users = $this->userRepository->getList('name');
        $isAdmin = Auth::user()->role == ADMIN || Auth::user()->role == SUPER_ADMIN;
        $isSale =  Auth::user()->role == SALE;
        $isWareHouseStaff = Auth::user()->role == WAREHOUSE_STAFF;
        $isStocker = Auth::user()->role == STOCKER;
        $isAccountant =  Auth::user()->role == ACCOUNTANT;
        $dateDeliverys = $this->commentRepository->getWhere(['type' => COMMENT_TYPE_ORDER, 'status' => DELIVERY, 'order_id' => $id])->pluck('created_at', 'order_id');
        return view('order.detail', compact('order', 'comments', 'users', 'isAdmin', 'isSale', 'isWareHouseStaff', 'isAccountant', 'isStocker', 'dateDeliverys'));
    }

    public function add(CreateUpdateOrderRequest $request)
    {
        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $customers = $this->customerRepository->getList('customer_name');
            $categories = $this->categoryRepository->getList('category_name');
            $bankAccounts = $this->bankAccountRepository->getListCustom('bank_code', 'bank_account_name');
            $discounts = $this->orderService->mapDiscounts();
            $discountsPrice = $this->orderService->mapDiscountsPrice();
            $discountsNote = $this->orderService->mapDiscountsNote();
            return view('order.add', compact('customers', 'categories', 'discounts', 'discountsPrice', 'discountsNote', 'bankAccounts'));
        }
        $data = $request->only([
            'customer_id',
            'product_id',
            'order_total',
            'order_discount',
            'quantity',
            'unit_price',
            'discount_percent',
            'discount_price',
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
            'product_price',
            'delivery_appointment_date',
            'bank_account_id',
            'payment_date',
            'payment_due_day'
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
        if (in_array($order->status, [DELIVERY, DELIVERED, COMPLETE])) {
            return abort(403, 'Unauthorized');
        }
        if (Auth::user()->role === STOCKER && $order->status === IN_PROCESSING && $order->payment_type === PAY_FULL) {
            return abort(403, 'Unauthorized');
        }
        if (in_array(Auth::user()->role,  [SALE, ADMIN, SUPER_ADMIN]) && $order->status === IN_PROCESSING) {
            return abort(403, 'Unauthorized');
        }
        if (Auth::user()->role === STOCKER && $order->status !== IN_PROCESSING) {
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
            $discountsPrice = $this->orderService->mapDiscountsPrice();
            $bankAccounts = $this->bankAccountRepository->getListCustom('bank_code', 'bank_account_name');
            $discountsNote = $this->orderService->mapDiscountsNote();
            if (Auth::user()->role == STOCKER) {
                $order = $this->orderService->replaceOrderDataInfo($order);
            }
            return view('order.edit', compact('order', 'customers', 'categories', 'discounts', 'discountsPrice', 'bankAccounts', 'discountsNote'));
        }

        $data = $request->only([
            'customer_id',
            'product_id',
            'order_total',
            'order_discount',
            'quantity',
            'unit_price',
            'discount_percent',
            'discount_price',
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
            'product_price',
            'delivery_appointment_date',
            'bank_account_id',
            'payment_date',
            'payment_due_day'
        ]);
        $msg = '';
        $updated = $this->orderService->updateOrder($order->id, $data, $msg);
        if ($updated) {
            return redirect()->route(Auth::user()->role == STOCKER ? 'stocker.order.detail' : 'order.detail', $order->id)->with(
                ['flash_level' => 'success', 'flash_message' => 'Cập nhật đơn hàng thành công']
            );
        }

        return redirect()->route(Auth::user()->role == STOCKER ? 'stocker.order.edit' : 'order.edit', $id)->with(
            ['flash_level' => 'error', 'flash_message' => $msg !== '' ? $msg : 'Lỗi không thể cập nhật đơn hàng']
        );
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        $order = $this->orderService->delete($id, true);
        if (!in_array(Auth::user()->role, [ADMIN, SUPER_ADMIN]) && in_array($order->status, [IN_PROCESSING, DELIVERY, DELIVERED, COMPLETE])) {
            return abort(403, 'Unauthorized');
        }
        $hasComment = $this->commentRepository->getWhere(['order_id' => $id])->count() > 0;
        if ($hasComment) {
            $this->commentRepository->deleteAll('order_id', $id);
        }
        $invoice = $this->invoiceRepository->getWhere(['order_id' => intval($id)])->first();
        if ($invoice !== null) {
            $this->invoiceRepository->delete($invoice->id);
        }
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

    public function updateStatusOrder(Request $request, $id, $status = null)
    {
        $order = $this->orderService->find(intval($id));
        $isSale = Auth::user()->role == SALE;
        $isAdmin = Auth::user()->role == SUPER_ADMIN || Auth::user()->role == ADMIN;
        $isStocker = Auth::user()->role == STOCKER;
        $dataUpdate = [];
        if ($request->isMethod('put') && $order) {
            if (($isAdmin || $isSale) && ($order->status == DRAFT || $order->status == REJECTED)) {
                $dataUpdate['status'] = IN_PROCESSING;
                if ($order->payment_type === PAY_FULL) {
                    $dataUpdate['payment_status'] = PAID;
                }
                if ($order->payment_type === DEPOSIT) {
                    $dataUpdate['payment_status'] = DEPOSITED;
                }
                $dataUpdate['customer_info'] = json_encode($order->customer);
                if (!empty($order->bankAccount)) {
                    $dataUpdate['bank_account_info'] = json_encode($order->bankAccount);
                }
                if (!$this->orderService->updateProductInfo($order)) {
                    return redirect()->route($isStocker ? 'stocker.order.detail' : 'order.detail', $id)->with(
                        ['flash_level' => 'error', 'flash_message' => 'Cập nhật trạng thái đơn hàng thất bại']
                    );
                }
            }
            if (($isAdmin || $isStocker) && $order->status == IN_PROCESSING) {
                $dataUpdate['status'] = DELIVERY;
            }
            if (($isAdmin || $isStocker) && $order->status == DELIVERY) {
                $dataUpdate['status'] = DELIVERED;
            }
            if (($isAdmin || $isStocker) && isset($status) && $status == REJECTED) {
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
                return redirect()->route($isStocker ? 'stocker.order.detail' : 'order.detail', $id)->with(
                    ['flash_level' => 'success', 'flash_message' => 'Cập nhật trạng thái đơn hàng thành công']
                );
            }
        }
        return redirect()->route($isStocker ? 'stocker.order.detail' : 'order.detail', $id)->with(
            ['flash_level' => 'error', 'flash_message' => 'Cập nhật trạng thái đơn hàng thất bại']
        );
    }

    public function indexPayment(Request $request)
    {
        $statusList = STATUS_ORDER;
        $statusPayment = STATUS_PAYMENT;
        $query = $request->input('query');
        $input = $request->input();
        $input['status_not_in'] = [DRAFT, REJECTED, DELIVERY, IN_PROCESSING];
        unset($statusList[DRAFT]);
        unset($statusList[REJECTED]);
        unset($statusList[DELIVERY]);
        unset($statusList[IN_PROCESSING]);
        $orders = $this->orderService->searchQuery($query, $input);
        foreach ($orders as &$order) {
            if (!empty($order->bank_account_info)) {
                $order->bankAccount = json_decode($order->bank_account_info);
            }
        }
        $customers = $this->customerRepository->getList('customer_name');
        $sales = $this->userRepository->getWhere(['role' => SALE])->pluck('name', 'id');
        $deliveredDates = $this->commentRepository->getWhere(['type' => COMMENT_TYPE_ORDER, 'status' => DELIVERED])->pluck('created_at', 'order_id');
        $dateDeliverys = $this->commentRepository->getWhere(['type' => COMMENT_TYPE_ORDER, 'status' => DELIVERY])->pluck('created_at', 'order_id');
        return view('payment.indexPayment', compact('orders', 'customers', 'statusPayment', 'statusList', 'sales', 'deliveredDates', 'dateDeliverys'));
    }

    public function detailPayment($id)
    {
        $order = $this->orderService->find($id);
        $bankAccounts = $this->bankAccountRepository->getListCustom('bank_code', 'bank_account_name');
        if (in_array($order->status, [DRAFT, REJECTED, DELIVERY, IN_PROCESSING])) {
            return abort(403, 'Unauthorized');
        }
        $order = $this->orderService->replaceOrderDataInfo($order);
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
        if ($order->payment_type == PAYMENT_ON_DELIVERY && in_array($order->status, [IN_PROCESSING, DELIVERY, REJECTED])) {
            $order->paid = null;
        }
        $users = $this->userRepository->getList('name');
        $isAccountant = Auth::user()->role == ACCOUNTANT;
        $isAdmin = Auth::user()->role == SUPER_ADMIN || Auth::user()->role == ADMIN;
        return view('payment.detailPayment', compact('order', 'users', 'comments', 'isAdmin', 'isAccountant', 'commentOrders', 'bankAccounts'));
    }
    public function updateStatusPayment(Request $request, $id, $status = null)
    {
        $order = $this->orderService->find(intval($id));
        $isAdmin = Auth::user()->role == SUPER_ADMIN || Auth::user()->role == ADMIN;
        $isSale = Auth::user()->role == SALE;
        $isAccountant = Auth::user()->role === ACCOUNTANT;
        if (($isAdmin || $isAccountant) && $order->status === DELIVERED && in_array($order->payment_status, [PAID, IN_PROCESSING])
            && $order->is_print_red_invoice === PRINTED_RED_INVOICE && $order->has_print_red_invoice === NOT_YET_RED_INVOICE
        ) {
            return redirect()->route('payment.detailPayment', $id)->with(
                ['flash_level' => 'error', 'flash_message' => 'Vui lòng xuất hóa đơn đỏ trước khi gửi xác nhận']
            );
        }

        $dataUpdate = [];
        $input = $request->input();
        if (isset($input['note'])) {
            $dataUpdate['note'] = $input['note'];
        }
        $route = 'payment.detailPayment';
        if (($isSale || $isAdmin) && ($order->status === DRAFT || $order->status === REJECTED)) {
            $route = 'order.detail';
        }
        if ($isAdmin && $order->status === DELIVERED) {
            $route = 'payment.indexPayment';
        }
        if (!empty($status) && intval($status) === REJECTED) {
            $dataUpdate['payment_status'] = REJECTED;
            $dataUpdate['payment_check_type'] = REJECTED;
        }
        if ($request->isMethod('put')) {
            $order = $this->orderService->updateStatusPayment($order, $dataUpdate);
            if ($order) {
                $comment = true;
                if (isset($dataUpdate['note']) && !empty($dataUpdate['status'])) {
                    $comment = $this->orderService->updateComment($id, $order, $dataUpdate, COMMENT_TYPE_ORDER);
                }
                if ($comment && isset($dataUpdate['note']) && !empty($dataUpdate['payment_status']) || !empty($dataUpdate['payment_check_type'])) {
                    $comment = $this->orderService->updateComment($id, $order, $dataUpdate, COMMENT_TYPE_PAYMENT);
                }
                if ($comment) {
                    return redirect()->route($route, $route === 'payment.indexPayment' ? [] : $id)->with(
                        ['flash_level' => 'success', 'flash_message' => 'Cập nhật trạng thái thanh toán thành công']
                    );
                }
            }
        }
        return redirect()->route($route, $route === 'payment.indexPayment' ? [] : $id)->with(
            ['flash_level' => 'error', 'flash_message' => 'Cập nhật trạng thái thanh toán thất bại']
        );
    }

    public function updatePayment(Request $request, $id)
    {
        $dataUpdate = [];
        $input = $request->input();
        $msg = '';
        if ($request->isMethod('put')) {
            $order = $this->orderService->updatePayment(intval($id), $input, $dataUpdate, $msg);
            if ($order) {
                return redirect()->route('payment.detailPayment', $id)->with(
                    ['flash_level' => 'success', 'flash_message' => $msg !== '' ? $msg : 'Cập nhật thanh toán thành công']
                );
            }
        }
        return redirect()->route('payment.detailPayment', $id)->with(
            ['flash_level' => 'error', 'flash_message' => $msg !== '' ? $msg : 'Cập nhật thanh toán thất bại']
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

    public function getBankAccountById($id)
    {
        return response()->json($this->bankAccountRepository->find($id));
    }

    public function printInvoice($id = null, $isDelivery = null)
    {
        if ($id === null) {
            return abort('404', 'Page not found');
        }
        $order = $this->orderService->find(intval($id));
        if (empty($order) || in_array($order->status, [DRAFT, REJECTED, IN_PROCESSING])) {
            return abort('404', 'Page not found');
        }
        $invoice = $this->invoiceRepository->getWhere(['order_id' => intval($id)])->first();
        $fileName = $order->order_number . '-' . date(FORMAT_DATE_TIME_VN_PATH) . '.pdf';
        $filePath = public_path('storage/pdf/deliveries/');
        if ($isDelivery === null) {
            $filePath = public_path('storage/pdf/invoices/');
        }
        if ($invoice !== null && file_exists($filePath . $invoice->pdf_invoice_path) && $isDelivery == null) {
            return response()->file($filePath . $invoice->pdf_invoice_path);
        }
        if ($invoice !== null && file_exists($filePath . $invoice->pdf_delivery_bill_path) && $isDelivery !== null) {
            return response()->file($filePath . $invoice->pdf_delivery_bill_path);
        }
        $order = $this->orderService->replaceOrderDataInfo($order);
        $dataCreate = [
            'order_id' => intval($id),
            'customer_id' => $order->customer_id,
            'sale_id' => $order->created_by,
        ];
        $dataUpdate = [];
        if ($isDelivery === null) {
            $dataCreate['pdf_invoice_path'] = $fileName;
            $dataUpdate['pdf_invoice_path'] = $fileName;
        } else {
            $dataCreate['pdf_delivery_bill_path'] = $fileName;
            $dataUpdate['pdf_delivery_bill_path'] = $fileName;
        }
        if ($invoice === null) {
            $invoice = $this->invoiceRepository->create($dataCreate);
        } else {
            $invoice = $this->invoiceRepository->update($invoice->id, $dataUpdate);
        }
        if ($isDelivery === null) {
            $pdf = Pdf::loadView('order.orderInvoice', compact('order'), ['invoiceId' => str_pad($invoice->id, 6, "0", STR_PAD_LEFT)]);
            $pdf->set_paper('a4', 'landscape');
        } else {
            $pdf = Pdf::loadView('order.deliveryBill', compact('order'), ['invoiceId' => str_pad($invoice->id, 6, "0", STR_PAD_LEFT)]);
        }
        if (!is_dir($filePath)) {
            mkdir($filePath, 0777, true);
        }
        file_put_contents($filePath . $fileName, $pdf->output());
        return response()->file($filePath . ($isDelivery === null ? $invoice->pdf_invoice_path : $invoice->pdf_delivery_bill_path));
    }
}
