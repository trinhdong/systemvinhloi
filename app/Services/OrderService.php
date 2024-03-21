<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\DiscountRepository;
use App\Repositories\OrderDetailRepository;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;
use function Nette\Utils\data;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $discountRepository;
    protected $orderDetailRepository;

    public function __construct(OrderRepository $orderRepository, DiscountRepository $discountRepository, OrderDetailRepository $orderDetailRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->discountRepository = $discountRepository;
        $this->orderDetailRepository = $orderDetailRepository;
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
        if (!empty($request['status'])) {
            $filters['status'] = intval($request['status']);
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
        if ($id === null) {
            $data['customer_id'] = intval($data['customer_id']);
            $data['order_total'] = floatval($data['order_total']);
            $data['order_discount'] = floatval($data['order_discount']);
            $data['order_date'] = Date::now()->format(FORMAT_DATE_TIME);
            $data['status'] = AWAITING;
            $data['product_id'] = array_values(array_filter($data['product_id']));
            $data['quantity'] = array_values(array_filter($data['quantity']));
            $data['unit_price'] = array_values(array_filter($data['unit_price']));

            if (count($data['product_id']) !== count($data['quantity']) || count($data['product_id']) !== count($data['unit_price'])) {
                return false;
            }

            $order = $this->create($data);
            if (!$order || !$this->processOrderDetail($data, $order->id)) {
                return false;
            }
            return $order;
        }
        if (!$this->processOrderDetail($data, $id)) {
            return false;
        }
        return $this->update($id, $data);
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
        }
        foreach ($orderDetails as $key => $orderDetail) {
            if (in_array($orderDetail['product_id'], $orderDetailProductIdMap)) {
                $orderDetailId = $orderDetailsIdMap[$orderDetails['product_id']];
                if (!$this->orderDetailRepository->update($orderDetailId, $orderDetail)) {
                    return false;
                }
                continue;
            }
            if (!$this->orderDetailRepository->create($orderDetail)) {
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
}
