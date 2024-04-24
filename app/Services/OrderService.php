<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use App\Repositories\OrderRepository;
use App\Repositories\DiscountRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\BankAccountRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\ProductRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $discountRepository;
    protected $orderDetailRepository;
    protected $customerService;
    protected $commentRepository;
    protected $bankAccountRepository;
    protected $invoiceRepository;
    protected $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        DiscountRepository $discountRepository,
        OrderDetailRepository $orderDetailRepository,
        CommentRepository $commentRepository,
        CustomerService $customerService,
        BankAccountRepository $bankAccountRepository,
        InvoiceRepository $invoiceRepository,
        ProductRepository $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->discountRepository = $discountRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->customerService = $customerService;
        $this->commentRepository = $commentRepository;
        $this->bankAccountRepository = $bankAccountRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->productRepository = $productRepository;
        $this->setRepository();
    }

    public function getRepository()
    {
        return OrderRepository::class;
    }

    public function searchQuery($query, $request = [])
    {
        $filters = [
            'order_number' => [
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
        ];
        if (!empty($request['status_not_in'])) {
            $filters['status'] = [
                'logical_operator' => 'AND',
                'operator' => 'NOT IN',
                'value' => $request['status_not_in']
            ];
        }
        if (!empty($request['payment_status_not_in'])) {
            $filters['payment_status'] = [
                'logical_operator' => 'AND',
                'operator' => 'NOT IN',
                'value' => $request['payment_status_not_in']
            ];
        }
        if (!empty($request['status'])) {
            $filters['status'] = intval($request['status']);
        }
        if (!empty($request['payment_status'])) {
            $filters['payment_status'] = intval($request['payment_status']);
        }
        if (!empty($request['payment_check_type'])) {
            $filters['payment_check_type'] = intval($request['payment_check_type']);
        }
        if (!empty($request['customer_id'])) {
            $filters['customer_id'] = intval($request['customer_id']);
        }
        if (!empty($request['sale_id'])) {
            $filters['created_by'] = intval($request['sale_id']);
        }
        if (!empty($request['delivered_from']) || !empty($request['delivered_to'])) {
            $conditions = [
                'type' => COMMENT_TYPE_ORDER,
                'status' => DELIVERED
            ];
        }
        if (!empty($request['delivered_from'])) {
            $deliveredFrom = \DateTime::createFromFormat(FORMAT_DATE_VN, $request['delivered_from']);
            if ($deliveredFrom) {
                $conditions[] = ['created_at', '>=', $deliveredFrom->format(FORMAT_DATE) . ' 00:00:00'];
            }
        }
        if (!empty($request['delivered_to'])) {
            $deliveredTo = \DateTime::createFromFormat(FORMAT_DATE_VN, $request['delivered_to']);
            if ($deliveredTo) {
                $conditions[] = ['created_at', '<=', $deliveredTo->format(FORMAT_DATE) . ' 23:59:59'];
            }
        }
        if (!empty($conditions)) {
            $orderIds = $this->commentRepository->getWhere($conditions)->pluck('order_id')->toArray();
            $filters['id'] = [
                'logical_operator' => 'AND',
                'operator' => 'IN',
                'value' => !empty($orderIds) ? $orderIds : [0]
            ];
        }

        $orderDate = \DateTime::createFromFormat(FORMAT_DATE_VN, $request['order_date'] ?? '');
        if ($orderDate) {
            $filters['order_date'] = [
                'logical_operator' => 'AND',
                'operator' => 'LIKE',
                'value' => $orderDate->format(FORMAT_DATE) . '%'
            ];
        }

        if (!empty($request['delivery_appointment_date'])) {
            $deliveryAppointmentDate = \DateTime::createFromFormat(FORMAT_DATE_VN, $request['delivery_appointment_date']);
            if ($deliveryAppointmentDate) {
                $filters['delivery_appointment_date'] = $deliveryAppointmentDate->format(FORMAT_DATE);
            }
        }

        return $this->paginate($filters, 'id');
    }

    public function createOrder(array $data, &$msg)
    {
        return $this->processOrder($data, null, $msg);
    }

    public function updateOrder($id, array $data, &$msg)
    {
        return $this->processOrder($data, $id, $msg);
    }

    private function listFieldstokerUpdateOrder()
    {
        return [
            'order_total',
            'order_discount',
            'order_total_product_price',
            'product_id',
            'quantity',
        ];
    }

    private function processOrder(array $data, $id = null, &$msg = '')
    {
        DB::beginTransaction();
        $data = $this->formatDataTypeOrder($data);
        if (!$this->validateDataOrder($data, $msg)) {
            return false;
        }
        $data['payment_status'] = UNPAID;
        $data['status'] = DRAFT;
        if ($id === null) {
            $data['order_date'] = Date::now()->format(FORMAT_DATE_TIME);
            $data['order_number'] = $this->generateOrderNumber($data['customer_id']);
            $order = $this->orderRepository->create($data, true);
            if (!$order || !$this->processOrderDetail($data, $order->id)) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return $order;
        }
        $isUpdateCustomer = $this->checkUpdateCustomer($data['customer_id'] ?? 0, $id);
        $data['order_number'] = $this->generateOrderNumber($data['customer_id'] ?? 0, true, $isUpdateCustomer);
        $data['paid'] = null;
        $data['customer_info'] = null;
        $data['bank_account_info'] = null;
        $data['payment_check_type'] = UNCHECK_PAYMENT;
        if (Auth::user()->role === STOCKER) {
            $data = array_intersect_key($data, array_flip($this->listFieldstokerUpdateOrder()));
            $data['has_update_quantity'] = HAD_UPDATE_QUANTITY;
        } else {
            $data['has_update_quantity'] = NOT_YET_UPDATE_QUANTITY;
        }
        if (!$this->processOrderDetail($data, $id)) {
            DB::rollBack();
            return false;
        }

        $order = $this->orderRepository->update($id, $data, true);
        $comment = $this->commentRepository->getWhere(['order_id' => $order->id]);
        if ($order->status === DRAFT && !$comment->isEmpty() && !$this->commentRepository->deleteAll('order_id', $order->id)
        ) {
            DB::rollBack();
            return false;
        }
        if (!$order) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return $order;
    }

    private function formatDataTypeOrder($data)
    {
        $data['customer_id'] = intval($data['customer_id'] ?? 0);
        $data['order_total'] = floatval($data['order_total']);
        $data['order_discount'] = floatval($data['order_discount']);
        $data['order_total_product_price'] = floatval($data['order_total_product_price']);
        $data['product_id'] = array_values(array_filter($data['product_id']));
        $data['quantity'] = array_values(
            array_filter(
                array_map(function ($quantity) {
                    return str_replace(',', '', $quantity);
                }, $data['quantity'])
            )
        );
        $data['unit_price'] = array_values(array_filter(str_replace(',', '', $data['unit_price'] ?? '')));
        $data['product_price'] = array_values(array_filter(str_replace(',', '', $data['product_price'] ?? '')));
        $data['discount_percent'] = array_values(array_filter($data['discount_percent'], function ($v) {
                return $v !== null && $v !== '' && floatval($v) >= 0;
            })
        );
        $data['discount_price'] = array_values(
            array_filter(
                array_map(function ($discountPrice) {
                    return str_replace(',', '', $discountPrice);
                }, $data['discount_price']),
                function ($v) {
                    return $v !== null && $v !== '' && floatval($v) >= 0;
                }
            )
        );
        $data['payment_type'] = intval($data['payment_type']);
        $data['payment_method'] = intval($data['payment_method']);
        $data['bank_account_id'] = $data['payment_method'] === TRANFER ? intval($data['bank_account_id'] ?? 0) : null;
        $data['payment_due_day'] = $data['payment_type'] === PAYMENT_ON_DELIVERY && !empty($data['payment_due_day']) ? intval($data['payment_due_day'] ?? 0) : null;
        if (!empty($data['payment_date'])) {
            $dayPaid = \DateTime::createFromFormat(FORMAT_DATE_VN, $data['payment_date']);
            if ($dayPaid) {
                $data['payment_date'] = $dayPaid->format(FORMAT_DATE);
            }
        }
        if (isset($data['deposit'])) {
            $data['deposit'] = $data['payment_type'] === DEPOSIT ? (float)str_replace(',', '', $data['deposit']) : null;
        }
        $data['note'] = array_values($data['note']);
        $data['is_print_red_invoice'] = intval($data['is_print_red_invoice'] ?? 0);
        if (!empty($data['delivery_appointment_date'])) {
            $deliveryAppointmentDate = \DateTime::createFromFormat(FORMAT_DATE_VN, $data['delivery_appointment_date']);
            if ($deliveryAppointmentDate) {
                $data['delivery_appointment_date'] = $deliveryAppointmentDate->format(FORMAT_DATE);
            }
        }
        return $data;
    }

    private function validateDataOrder($data, &$msg)
    {
        if (!empty($data['deposit']) && floatval($data['deposit']) >= floatval($data['order_total'])) {
            $msg = 'Vui lòng nhập số tiền cọc nhỏ hơn tổng tiền';
            return false;
        }
        if (count($data['product_id']) !== count($data['quantity'])
            || count($data['product_id']) !== count($data['unit_price'])
            || count($data['product_id']) !== count($data['product_price'])
            || count($data['product_id']) !== count($data['discount_percent'])
            || count($data['product_id']) !== count($data['discount_price'])
            || count($data['product_id']) !== count($data['note'])
        ) {
            $msg = 'Có lỗi sảy ra, vui lòng thử lại';
            return false;
        }
        if (!$this->validateTotalOrder($data)) {
            $msg = 'Có lỗi sảy ra, vui lòng thử lại';
            return false;
        }
        return true;
    }

    public function processOrderDetail(array $data, $orderId)
    {
        $orderDetails = [];
        $orderDetailsIdMap = $this->orderDetailRepository
            ->getWhere(['order_id' => $orderId])
            ->pluck('id', 'product_id')
            ->toArray();
        $orderDetailProductIdMap = array_flip($orderDetailsIdMap);
        $discountNote = $this->mapDiscountsNote();
        foreach ($data['product_id'] as $key => $productId) {
            $orderDetails[$key]['order_id'] = $orderId;
            $orderDetails[$key]['product_id'] = intval($productId);
            $orderDetails[$key]['quantity'] = floatval($data['quantity'][$key]);
            if (!(Auth::user()->role === STOCKER)) {
                $orderDetails[$key]['unit_price'] = floatval($data['unit_price'][$key]);
                $orderDetails[$key]['product_price'] = floatval($data['product_price'][$key]);
                $orderDetails[$key]['discount_percent'] = floatval($data['discount_percent'][$key]);
                $orderDetails[$key]['discount_price'] = floatval($data['discount_price'][$key]);
                $orderDetails[$key]['discount_note'] = $discountNote[$data['customer_id'] . '_' . intval($productId)] ?? null;
                $orderDetails[$key]['note'] = $data['note'][$key];
                $orderDetails[$key]['product_info'] = null;
            }
        }
        if (!$this->checkDuplicateOrderDetai($orderDetails)) {
            return false;
        }
        $dataDelete = $orderDetailsIdMap;
        foreach ($orderDetails as $key => $orderDetail) {
            if (in_array($orderDetail['product_id'], $orderDetailProductIdMap)) {
                unset($dataDelete[$orderDetail['product_id']]);
                $orderDetailId = $orderDetailsIdMap[$orderDetail['product_id']];
                if (!$this->orderDetailRepository->update($orderDetailId, $orderDetail, true)) {
                    return false;
                }
                continue;
            }
            if (!$this->orderDetailRepository->create($orderDetail, true)) {
                unset($dataDelete[$orderDetail['product_id']]);
                return false;
            }
        }
        if (!empty($dataDelete)) {
            foreach ($dataDelete as $id) {
                if (!$this->orderDetailRepository->delete($id, true)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function mapDiscounts()
    {
        $discounts = $this->discountRepository->getAll();

        $discountMap = [];
        foreach ($discounts as $discount) {
            $key = $discount->customer_id . '_' . $discount->product_id;
            $discountMap[$key] = $discount->discount_percent;
        }

        return $discountMap;
    }

    public function mapDiscountsPrice()
    {
        $discounts = $this->discountRepository->getAll();

        $discountMap = [];
        foreach ($discounts as $discount) {
            $key = $discount->customer_id . '_' . $discount->product_id;
            $discountMap[$key] = $discount->discount_price;
        }

        return $discountMap;
    }

    public function mapDiscountsNote()
    {
        $discounts = $this->discountRepository->getAll();

        $discountMap = [];
        foreach ($discounts as $discount) {
            $key = $discount->customer_id . '_' . $discount->product_id;
            $discountMap[$key] = $discount->note;
        }

        return $discountMap;
    }

    public function updateStatusPayment($order, &$dataUpdate)
    {
        $isAccountant = Auth::user()->role == ACCOUNTANT;
        $isAdmin = Auth::user()->role == SUPER_ADMIN || Auth::user()->role == ADMIN;
        $isSale = Auth::user()->role == SALE;
        if ($isAdmin && !empty($dataUpdate['payment_status']) && $dataUpdate['payment_status'] === REJECTED) {
            return $this->update($order->id, $dataUpdate);
        }
        if ($isSale) {
            $dataUpdate['payment_check_type'] = SALE_CHECK_PAYMENT;
        }
        if ($isAccountant) {
            $dataUpdate['payment_check_type'] = ACCOUNTANT_CHECK_PAYMENT;
        }
        if ($isAdmin) {
            $dataUpdate['payment_check_type'] = ADMIN_CHECK_PAYMENT;
        }
        if ($isSale || $isAdmin && ($order->status === DRAFT || $order->status === REJECTED)) {
            if ($order->payment_type === PAY_FULL) {
                $dataUpdate['payment_status'] = PAID;
                $dataUpdate['paid'] = $order->order_total;
            }
            if ($order->payment_type === DEPOSIT) {
                $dataUpdate['payment_status'] = DEPOSITED;
                $dataUpdate['paid'] = $order->deposit;
            }
        }
        if ($isAccountant && $order->status === DELIVERED && in_array($order->payment_status, [PAID, IN_PROCESSING])) {
            $dataUpdate['payment_status'] = PAID;
        }
        if ($isAdmin && $order->status === DELIVERED && in_array($order->payment_status, [PAID, IN_PROCESSING])) {
            $dataUpdate['payment_status'] = COMPLETE;
            $dataUpdate['status'] = COMPLETE;
        }
        return $this->update($order->id, $dataUpdate);
    }

    public function updatePayment($id, $input, &$dataUpdate, &$msg)
    {
        $order = $this->find($id);
        $paid = str_replace(',', '', $input['paid'] ?? '');
        if (isset($input['has_print_red_invoice'])) {
            $dataUpdate['has_print_red_invoice'] = intval($input['has_print_red_invoice'] ?? 0);
        }
        if (isset($input['note'])) {
            $dataUpdate['note'] = $input['note'];
        }
        if (isset($dataUpdate['has_print_red_invoice']) && $paid === '' && !isset($input['payment_date'])) {
            $order = $this->update(intval($id), $dataUpdate);
            if (!$order) {
                $msg = 'Cập nhật trạng thái xuất hoá đơn đỏ thất bại';
                return false;
            }
            $msg = 'Cập nhật trạng thái xuất hoá đơn đỏ thành công';
            return $order;
        }
        $dayPaid = \DateTime::createFromFormat(FORMAT_DATE_VN, $input['payment_date']);
        if ($paid == '' || !$dayPaid) {
            $msg = $paid == '' ? 'Vui lòng nhập số tiền đã thanh toán' : 'Vui lòng nhập ngày thanh toán';
            return false;
        }
        if (!empty($input['payment_method'])) {
            $dataUpdate['payment_method'] = intval($input['payment_method']);
        }
        if ($order->payment_type === PAYMENT_ON_DELIVERY && empty($dataUpdate['payment_method'])) {
            $msg = 'Vui lòng nhập phương thức thanh toán';
            return false;
        }
        if ((($order->payment_type === PAYMENT_ON_DELIVERY  && !empty($dataUpdate['payment_method']) && $dataUpdate['payment_method'] === TRANFER)
            || ($order->payment_type !== PAYMENT_ON_DELIVERY && $order->payment_method === TRANFER))
            && !$this->checkPaymentMethodTranfer($input, $dataUpdate)
        ) {
            $msg = 'Vui lòng nhập đầy đủ thông tin tài khoản ngân hàng';
            return false;
        }
        if ($order->payment_type === PAYMENT_ON_DELIVERY && !empty($dataUpdate['payment_method']) && $dataUpdate['payment_method'] === CASH) {
            $dataUpdate['bank_name'] = null;
            $dataUpdate['bank_code'] = null;
            $dataUpdate['bank_customer_name'] = null;
            $dataUpdate['bank_account_info'] = null;
            $dataUpdate['bank_account_id'] = null;
        }
        $dataUpdate['payment_date'] = $dayPaid->format(FORMAT_DATE);
        $dataUpdate['paid'] = floatval($paid);
        $dataUpdate['payment_status'] = IN_PROCESSING;
        $order = $this->update(intval($id), $dataUpdate);
        return $order && $this->updateComment($id, $order, $dataUpdate, COMMENT_TYPE_PAYMENT);
    }

    private function checkPaymentMethodTranfer($input, &$dataUpdate)
    {
        if (!isset($input['bank_name']) || !isset($input['bank_code']) || !isset($input['bank_customer_name']) || !isset($input['bank_account_id'])) {
            return false;
        }
        $dataUpdate['bank_name'] = $input['bank_name'];
        $dataUpdate['bank_code'] = $input['bank_code'];
        $dataUpdate['bank_customer_name'] = $input['bank_customer_name'];
        $dataUpdate['bank_account_id'] = intval($input['bank_account_id']);
        $dataUpdate['bank_account_info'] = json_encode($this->bankAccountRepository->find($dataUpdate['bank_account_id']));
        return true;
    }

    public function getDiscountByCustomerId(int $customerId, array $productIdsNotIn = [])
    {
        return $this->discountRepository->getDiscountByCustomerId($customerId, $productIdsNotIn);
    }

    public function updateProductInfo($order)
    {
        foreach ($order->orderDetail as $orderDetail) {
            DB::beginTransaction();
            if (!$this->orderDetailRepository->update($orderDetail->id, ['product_info' => json_encode($orderDetail->product)], true)) {
                DB::rollBack();
                return false;
            }
            DB::commit();
        }
        return true;
    }

    public function updateComment($id, $order, $data, $type)
    {
        $status = $order->status;
        if ($type === COMMENT_TYPE_PAYMENT) {
            $status = $order->payment_status;
        }
        return $this->commentRepository->create([
            'order_id' => intval($id),
            'type' => $type,
            'status' => $status,
            'note' => $data['note'] ?? ''
        ]);
    }

    public function generateOrderNumber($customerId, $isUpdateOrder = false, $isUpdateCustomer = false)
    {
        $totalOrder = $this->orderRepository->getAll(true)->count() + 1;
        $totalOrderOfCus = $this->orderRepository->getWhere([
            'customer_id' => $customerId,
            ['created_at' , '>=', date(FORMAT_DATE_TIME, strtotime(date('Y') . '-01-01' . '00:00:00'))]
        ], true)->count() + 1;
        if ($isUpdateOrder) {
            $totalOrder = $totalOrder - 1;
            $totalOrderOfCus = $isUpdateCustomer ? $totalOrderOfCus :  $totalOrderOfCus - 1;
        }
        return $customerId . '-' . $totalOrderOfCus . '-' . $totalOrder .'-' .'VINHLOI' . '-' . date('Y');
    }

    private function checkUpdateCustomer($customerId, $orderId)
    {
        $order = $this->find($orderId);
        return $order->customer_id !== $customerId;
    }

    public function replaceOrderDataInfo($order)
    {
        if (!empty($order->customer_info)) {
            $order->customer = json_decode($order->customer_info);
        }
        if (!empty($order->bank_account_info)) {
            $order->bankAccount = json_decode($order->bank_account_info);
        }
        foreach ($order->orderDetail as &$orderDetail) {
            if (!empty($orderDetail->product_info)) {
                $orderDetail->product = json_decode($orderDetail->product_info);
            }
        }
        return $order;
    }

    public function printInvoice($order, $isDelivery)
    {
        $invoice = $this->invoiceRepository->getWhere(['order_id' => $order->id])->first();
        $fileName = $order->order_number . '-' . date(FORMAT_DATE_TIME_VN_PATH) . '.pdf';
        $filePath = public_path('storage/pdf/deliveries/');
        if ($isDelivery === null) {
            $filePath = public_path('storage/pdf/invoices/');
        }
        if ($invoice !== null && $invoice->pdf_invoice_path !== null && file_exists($filePath . $invoice->pdf_invoice_path) && $isDelivery == null) {
            return response()->file($filePath . $invoice->pdf_invoice_path);
        }
        if ($invoice !== null && $invoice->pdf_delivery_bill_path !== null && file_exists($filePath . $invoice->pdf_delivery_bill_path) && $isDelivery !== null) {
            return response()->file($filePath . $invoice->pdf_delivery_bill_path);
        }
        $order = $this->replaceOrderDataInfo($order);
        $dataCreate = [
            'order_id' => $order->id,
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
        if (!$invoice) {
            return abort('500', 'Data not found');
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

    private function checkDuplicateOrderDetai(array $orderDetails)
    {
        $seenProductIds = [];
        foreach ($orderDetails as $orderDetail) {
            $productId = $orderDetail['product_id'];
            if (in_array($productId, $seenProductIds)) {
                return false;
            }
            $seenProductIds[] = $productId;
        }
        return true;
    }

    private function validateTotalOrder($data)
    {
        $totalOrder = 0;
        $totalProductPrice = 0;
        $totalDiscountPrice = 0;
        foreach ($data['product_id'] as $key => $productId) {
            $product = $this->productRepository->find(intval($productId));
            if (!$product) {
                return false;
            }
            $quantityPerPackage = $product->quantity_per_package;
            $unitPrice = floatval($data['unit_price'][$key]);
            $quantity = intval($data['quantity'][$key]);
            $discountPrice = floatval($data['discount_price'][$key]);
            $productPrice = floatval($data['product_price'][$key]);
            $totalOrder += $quantity * $unitPrice * $quantityPerPackage;
            $totalDiscountPrice += $quantity * $discountPrice * $quantityPerPackage;
            $totalProductPrice += $quantity * $productPrice * $quantityPerPackage;
        }
        if ($data['order_total'] !== $totalOrder
            || $data['order_discount'] !== $totalDiscountPrice
            || $data['order_total_product_price'] !== $totalProductPrice
        ) {
            return false;
        }
        return true;
    }
}
