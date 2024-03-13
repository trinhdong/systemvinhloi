<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Auth;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
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

        return $this->customerRepository->paginate($filters, 'id');
    }

    public function getCustomerById($id)
    {
        return $this->customerRepository->getCustomerById($id);
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
            return $this->customerRepository->createCustomer($data);
        } else {
            return $this->customerRepository->updateCustomer($id, $data);
        }
    }

    public function deleteCustomer($id)
    {
        return $this->customerRepository->deleteCustomer($id);
    }
}
