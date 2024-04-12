<?php
namespace App\Repositories;

use App\Models\BillDelivery;

class BillDeliveryRepository extends BaseRepository
{
    protected $billDelivery;
    public function __construct(BillDeliveryRepository $billDelivery)
    {
        $this->billDelivery = $billDelivery;
        $this->setModel();
    }

    public function getModel()
    {
        return BillDelivery::class;
    }
}
