<?php
namespace App\Repositories;

use App\Models\Discount;

class DiscountRepository extends BaseRepository
{
    protected $discount;
    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
        $this->setModel();
    }

    public function getModel()
    {
        return Discount::class;
    }
}
