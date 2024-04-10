<?php
namespace App\Repositories;

use App\Models\BankAccount;

class BankAccountRepository extends BaseRepository
{
    protected $bankAccount;
    public function __construct(BankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;
        $this->setModel();
    }

    public function getModel()
    {
        return BankAccount::class;
    }
}
