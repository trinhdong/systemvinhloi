<?php

namespace App\Services;

use App\Repositories\BankAccountRepository;

class BankAccountService extends BaseService
{
    protected $bankAccountRepository;

    public function __construct(BankAccountRepository $bankAccountRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->setRepository();
    }

    public function getRepository(){
        return BankAccountRepository::class;
    }

    public function searchQuery($query, $request = [])
    {
        $filters = [
            'bank_code' => [
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
            'bank_name' => [
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
            'bank_account_name' => [
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
        ];
        return $this->paginate($filters, 'id');
    }

    public function createBankAccount(array $data)
    {
        return $this->processBankAccount($data);
    }

    public function updateBankAccount($id, array $data)
    {
        return $this->processBankAccount($data, $id);
    }

    private function processBankAccount(array $data, $id = null)
    {
        if ($id === null) {
            return $this->create($data);
        }
        return $this->update($id, $data);
    }
}
