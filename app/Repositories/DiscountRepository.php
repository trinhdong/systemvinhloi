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

    public function getDiscountByCustomerId(int $customerId, array $productIdsNotIn = [])
    {
        return $this->discount
            ->where('customer_id', '=', $customerId)
            ->whereNotIn('product_id', $productIdsNotIn)
            ->get();
    }
}
