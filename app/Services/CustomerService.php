<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\DiscountRepository;

class CustomerService extends BaseService
{
    protected $customerRepository;
    protected $discountRepository;

    public function __construct(CustomerRepository $customerRepository, DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;
        $this->customerRepository = $customerRepository;
        $this->setRepository();
    }

    public function getRepository()
    {
        return CustomerRepository::class;
    }

    public function searchQuery($query, $request = [])
    {
        $filters = [
            'customer_name' => [
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
            'email' => [
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
            'phone' => [
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
        ];
        if (!empty($request['area_id'])) {
            $filters['area_id'] = intval($request['area_id']);
        }
        return $this->paginate($filters, 'id');
    }

    public function createCustomer(array $data)
    {
        return $this->processCustomer($data);
    }

    public function updateCustomer($id, array $data)
    {
        return $this->processCustomer($data, $id);
    }

    private function processCustomer(array $data, $id = null)
    {
        $data['area_id'] = intval($data['area_id']);
        if ($id === null) {
            $customer = $this->customerRepository->create($data);
            if (!$customer || !$this->processDiscount($data, $customer->id)) {
                return false;
            }

            return $customer;
        }
        if (!$this->processDiscount($data, $id)) {
            return false;
        }
        return $this->customerRepository->update($id, $data);
    }

    public function processDiscount(array $data, $customerId)
    {
        if (empty($data['product_id'])) {
            return true;
        }
        $discounts = [];
        $discountsIdMap = $this->discountRepository
            ->getWhere(['customer_id' => $customerId])
            ->pluck('id', 'product_id')
            ->toArray();
        $discountsProductIdMap = array_flip($discountsIdMap);
        $data['product_id'] = array_values(array_filter($data['product_id']));
        $data['discount_percent'] = array_values(array_filter($data['discount_percent']));
        foreach ($data['product_id'] as $key => $productId) {
            $discounts[$key]['product_id'] = intval($productId);
            $discounts[$key]['discount_percent'] = floatval($data['discount_percent'][$key]);
            $discounts[$key]['customer_id'] = $customerId;
        }
        foreach ($discounts as $key => $discount) {
            if (in_array($discount['product_id'], $discountsProductIdMap)) {
                $discountId = $discountsIdMap[$discount['product_id']];
                if (!$this->discountRepository->update($discountId, $discount)) {
                    return false;
                }
                continue;
            }
            if (!$this->discountRepository->create($discount)) {
                return false;
            }
        }
        return true;
    }
}
