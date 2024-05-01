<?php

namespace App\Services;

use App\Repositories\EmployeeCustomerRepository;
use Hash;

class EmployeeCustomerService extends BaseService
{

    protected $employeeCustomerRepository;

    /**
     *
     * @param App\Repositories\EmployeeCustomerRepository $employeeCustomerRepository
     * @access public
     * @return void
     */
    public function __construct(EmployeeCustomerRepository $employeeCustomerRepository)
    {
        $this->employeeCustomerRepository = $employeeCustomerRepository;
        $this->setRepository();
    }

    /**
     *
     * @access public
     * @return Repository
     */
    public function getRepository()
    {
        return EmployeeCustomerRepository::class;
    }
}

