<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\DiscountRepository;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        $data['area_id'] = intval($data['area_id']);
        if ($id === null) {
            $customer = $this->customerRepository->create($data, true);
            if (!$customer || !$this->processDiscount($data, $customer->id)) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return $customer;
        }
        if (!$this->processDiscount($data, $id)) {
            DB::rollBack();
            return false;
        }
        $customer = $this->customerRepository->update($id, $data, true);
        if (!$customer) {
            DB::rollBack();
        }
        DB::commit();
        return $customer;
    }

    public function processDiscount(array $data, $customerId, $isAddOrder = false)
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
        $data['discount_percent'] = array_values(array_filter($data['discount_percent'], function ($v) {
            return $v !== null && $v !== '' && floatval($v) >= 0;
        }));
        if (count($data['note']) > count($data['product_id'])) {
            unset($data['note'][0]);
            $data['note'] = array_values($data['note']);
        }

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
        foreach ($data['product_id'] as $key => $productId) {
            $discounts[$key]['product_id'] = intval($productId);
            $discounts[$key]['discount_percent'] = floatval($data['discount_percent'][$key]);
            $discounts[$key]['discount_price'] = floatval($data['discount_price'][$key]);
            $discounts[$key]['note'] = $data['note'][$key];
            $discounts[$key]['customer_id'] = $customerId;
        }
        foreach ($discounts as $key => $discount) {
            if (in_array($discount['product_id'], $discountsProductIdMap)) {
                $discountId = $discountsIdMap[$discount['product_id']];
                if (!$isAddOrder && !$this->discountRepository->update($discountId, $discount, true)) {
                    return false;
                }
                continue;
            }
            if (!$this->discountRepository->create($discount, true)) {
                return false;
            }
        }
        return true;
    }
}
