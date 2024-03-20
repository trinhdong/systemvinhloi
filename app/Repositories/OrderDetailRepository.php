<?php
namespace App\Repositories;

use App\Models\OrderDetail;

class OrderDetailRepository extends BaseRepository
{
    protected $orderDetail;
    public function __construct(OrderDetail $orderDetail)
    {
        $this->orderDetail = $orderDetail;
        $this->setModel();
    }

    public function getModel()
    {
        return OrderDetail::class;
    }
}
