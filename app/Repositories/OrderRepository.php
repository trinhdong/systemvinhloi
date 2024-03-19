<?php
namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends BaseRepository
{
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->setModel();
    }

    public function getModel()
    {
        return Order::class;
    }
}
