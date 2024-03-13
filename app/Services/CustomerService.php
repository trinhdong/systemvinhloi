<?php

namespace App\Services;

use App\Repositories\CustomerRepository;

class CustomerService extends BaseService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->setRepository();
    }

    public function getRepository(){
        return CustomerRepository::class;
    }

    public function searchQuery($query, $request = [])
    {
        $filters = [
            'customer_name' => [
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
            'email' => [
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
            'phone' => [
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
        ];
        if (!empty($request['area_id'])) {
            $filters['area_id'] = $request['area_id'];
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
        if ($id === null) {
            return $this->customerRepository->create($data);
        } else {
            return $this->customerRepository->update($id, $data);
        }
    }
}
