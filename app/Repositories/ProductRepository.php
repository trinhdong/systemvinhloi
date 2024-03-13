<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->setModel();
    }

    public function getModel()
    {
        return Product::class;
    }
}
