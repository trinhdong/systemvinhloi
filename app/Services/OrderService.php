<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\DiscountRepository;
use App\Repositories\OrderDetailRepository;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $discountRepository;
    protected $orderDetailRepository;
    protected $customerService;

    public function __construct(
        OrderRepository $orderRepository,
        DiscountRepository $discountRepository,
        OrderDetailRepository $orderDetailRepository,
        CustomerService $customerService
    ) {
        $this->orderRepository = $orderRepository;
        $this->discountRepository = $discountRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->customerService = $customerService;
        $this->setRepository();
    }

    public function getRepository(){
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
        if (!empty($request['customer_id'])) {
            $filters['customer_id'] = intval($request['customer_id']);
        }

        if (!empty($request['order_date'])) {
            $filters['order_date'] =[
                'logical_operator' => 'AND',
                'operator' => 'LIKE',
                'value' => $request['order_date'] . '%'
            ];
        }

        return $this->paginate($filters, 'id');
    }

    public function createOrder(array $data)
    {
        return $this->processOrder($data);
    }

    public function updateOrder($id, array $data)
    {
        return $this->processOrder($data, $id);
    }

    private function processOrder(array $data, $id = null)
    {
        DB::beginTransaction();
        $data['order_total'] = floatval($data['order_total']);
        $data['order_discount'] = floatval($data['order_discount']);
        $data['order_total_product_price'] = floatval($data['order_total_product_price']);
        $data['payment_type'] = intval($data['payment_type']);
        $data['payment_method'] = intval($data['payment_method']);
        $data['product_id'] = array_values(array_filter($data['product_id']));
        $data['quantity'] = array_values(array_filter(array_map(function ($quantity) {
            return str_replace(',', '', $quantity);
        }, $data['quantity'])));
        $data['unit_price'] = array_values(array_filter($data['unit_price']));
        $data['product_price'] = array_values(array_filter($data['product_price']));
        $data['discount_percent'] = array_values(array_filter($data['discount_percent']));
        $data['payment_status'] = UNPAID;
        if (!empty($data['deposit'])) {
            $data['deposit'] = (float) str_replace(',', '', $data['deposit']);
        }
        $data['note'] = array_values($data['note']);
        if (!empty($data['is_print_red_invoice'])) {
            $data['is_print_red_invoice'] = intval($data['is_print_red_invoice']);
        }

        if (count($data['product_id']) !== count($data['quantity'])
            || count($data['product_id']) !== count($data['unit_price'])
            || count($data['product_id']) !== count($data['product_price'])
            || count($data['product_id']) !== count($data['discount_percent'])
            || count($data['product_id']) !== count($data['note'])
        ) {
            return false;
        }
        if ($id === null) {
            $data['status'] = DRAFT;
            $data['customer_id'] = intval($data['customer_id']);
            $data['order_date'] = Date::now()->format(FORMAT_DATE_TIME);
            $order = $this->create($data, true);
            if (!$order
                || !$this->processOrderDetail($data, $order->id)
                || !$this->customerService->processDiscount($data, $order->customer_id, true)
            ) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return $order;
        }
        if (!$this->processOrderDetail($data, $id)
            || !$this->customerService->processDiscount($data, intval($data['customer_id'], true))
        ) {
            DB::rollBack();
            return false;
        }
        $order = $this->update($id, $data, true);
        if (!$order) {
            DB::rollBack();
        }
        DB::commit();
        return $order;
    }

    public function processOrderDetail(array $data, $orderId)
    {
        $orderDetails = [];
        $orderDetailsIdMap = $this->orderDetailRepository
            ->getWhere(['order_id' => $orderId])
            ->pluck('id', 'product_id')
            ->toArray();
        $orderDetailProductIdMap = array_flip($orderDetailsIdMap);
        foreach ($data['product_id'] as $key => $productId) {
            $orderDetails[$key]['order_id'] = $orderId;
            $orderDetails[$key]['product_id'] = intval($productId);
            $orderDetails[$key]['quantity'] = floatval($data['quantity'][$key]);
            $orderDetails[$key]['unit_price'] = floatval($data['unit_price'][$key]);
            $orderDetails[$key]['product_price'] = floatval($data['product_price'][$key]);
            $orderDetails[$key]['discount_percent'] = floatval($data['discount_percent'][$key]);
            $orderDetails[$key]['note'] = $data['note'][$key];
        }
        foreach ($orderDetails as $key => $orderDetail) {
            if (in_array($orderDetail['product_id'], $orderDetailProductIdMap)) {
                $orderDetailId = $orderDetailsIdMap[$orderDetail['product_id']];
                if (!$this->orderDetailRepository->update($orderDetailId, $orderDetail, true)) {
                    return false;
                }
                continue;
            }
            if (!$this->orderDetailRepository->create($orderDetail, true)) {
                return false;
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

    public function updateStatusPayment($id, $order, &$dataUpdate)
    {
        $paid = $dataUpdate['paid'];
        if ($order->status == AWAITING && in_array($order->payment_type, [PAY_FULL, DEPOSIT]) && (in_array($order->payment_status, [UNPAID, IN_PROCESSING]))) {
            $dataUpdate['status'] = CONFIRMED;
            $dataUpdate['payment_status'] = $order->payment_type == PAY_FULL ? PAID : DEPOSITED;
            if (floatval($paid) < $order->deposit) {
                unset($dataUpdate['status']);
                $dataUpdate['payment_status'] = IN_PROCESSING;
            }
            if (floatval($paid)>= $order->order_total) {
                $dataUpdate['payment_status'] = PAID;
            }
            if (!empty($dataUpdate['status'])) {
                $dataUpdate['customer_info'] = json_encode($order->customer);
            }
        }
        if ($order->status == DELIVERED && (in_array($order->payment_status, [UNPAID, DEPOSITED, IN_PROCESSING, REJECTED]))) {
            $dataUpdate['payment_status'] = PAID;
            if (floatval($paid) < $order->order_total) {
                $dataUpdate['payment_status'] = IN_PROCESSING;
            }
        }
        if ($order->status == DELIVERED && $order->payment_status == PAID) {
            $dataUpdate = [
                'status' => COMPLETE,
                'payment_status' => COMPLETE
            ];
        }
        if (isset($status) && $status == REJECTED) {
            if ($order->status == AWAITING) {
                $dataUpdate = ['status' => REJECTED];
            }
            if ($order->status == DELIVERED && $order->payment_status == PAID) {
                $dataUpdate = ['payment_status' => REJECTED];
            }
        }
        return $this->update(intval($id), $dataUpdate);
    }
}
