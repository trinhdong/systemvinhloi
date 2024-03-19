<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\DiscountRepository;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $discountRepository;

    public function __construct(OrderRepository $orderRepository, DiscountRepository $discountRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->discountRepository = $discountRepository;
        $this->setRepository();
    }

    public function getRepository(){
        return OrderRepository::class;
    }

    public function searchQuery($query, $request = [])
    {
        $filters = [
        ];

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
            return $this->create($data);
        } else {
            return $this->update($id, $data);
        }
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
