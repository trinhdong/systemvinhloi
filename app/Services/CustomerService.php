<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use App\Repositories\DiscountRepository;
use App\Repositories\EmployeeCustomerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerService extends BaseService
{
    protected $customerRepository;
    protected $discountRepository;
    protected $employeeCustomerRepository;


    public function __construct(CustomerRepository $customerRepository, DiscountRepository $discountRepository, EmployeeCustomerRepository $employeeCustomerRepository)
    {
        $this->discountRepository = $discountRepository;
        $this->customerRepository = $customerRepository;
        $this->employeeCustomerRepository = $employeeCustomerRepository;
        $this->setRepository();
    }

    public function getRepository()
    {
        return CustomerRepository::class;
    }

    public function searchQuery($query, $request = [], $isSale)
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
        if ($isSale) {
            $userId = Auth::user()->id;
            $filters['join'] = [
                [
                    'table' => 'employee_customers',
                    'table_id' => 'employee_customers.customer_id',
                    'table_reference_id' => 'customers.id'
                ]
            ];
            $filters['employee_customers.user_id'] = [
                'operator' => '=',
                'value' => $userId
            ];
        }
        return $this->paginate($filters, 'customers.id');
    }

    public function createCustomer(array $data, $isSale)
    {
        return $this->processCustomer($data,null, $isSale, '');
    }

    public function updateCustomer($id, array $data, $isAdmin)
    {
        return $this->processCustomer($data, $id,'', $isAdmin);
    }

    private function processCustomer(array $data, $id = null, $isSale, $isAdmin)
    {
        DB::beginTransaction();
        $data['area_id'] = intval($data['area_id']);
        if ($id === null) {
            $customer = $this->customerRepository->create($data, true);
            if ($customer && $isSale) {
                $this->employeeCustomerRepository->create([
                    'user_id' => Auth::id(),
                    'customer_id' => $customer->id,
                ]);
            }
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
        if($customer && $isAdmin){
            $this->employeeCustomerRepository->updateOrInsertData([
                'customer_id' => $customer->id,
            ],[
                'user_id' => $data['user_id'],
            ]);
        }
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
        if (!$this->checkDuplicateDiscount($discounts)) {
            return false;
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

    private function checkDuplicateDiscount(array $discounts)
    {
        $seenProductIds = [];
        foreach ($discounts as $discount) {
            $productId = $discount['product_id'];
            if (in_array($productId, $seenProductIds)) {
                return false;
            }
            $seenProductIds[] = $productId;
        }
        return true;
    }
}
