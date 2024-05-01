<?php
namespace App\Repositories;

use App\Models\Discount;
use App\Models\EmployeeCustomer;

class EmployeeCustomerRepository extends BaseRepository
{
    protected $employeeCustomer;
    public function __construct(EmployeeCustomer $employeeCustomer)
    {
        $this->employeeCustomer = $employeeCustomer;
        $this->setModel();
    }

    public function getModel()
    {
        return EmployeeCustomer::class;
    }

}
