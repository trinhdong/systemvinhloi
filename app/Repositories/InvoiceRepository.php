<?php
namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepository extends BaseRepository
{
    protected $invoice;
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->setModel();
    }

    public function getModel()
    {
        return Invoice::class;
    }
}
