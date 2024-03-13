<?php
namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends BaseRepository
{
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->setModel();
    }

    public function getModel()
    {
        return Customer::class;
    }

    public function getCustomerById($id)
    {
        return $this->find($id);
    }

    public function createCustomer(array $data)
    {
        return $this->create($data);
    }

    public function updateCustomer($id, array $data)
    {
        return $this->update($id, $data);
    }

    public function deleteCustomer($id)
    {
        return $this->delete($id);
    }
}
