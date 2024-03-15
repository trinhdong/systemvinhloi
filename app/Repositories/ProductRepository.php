<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->setModel();
    }

    public function getModel()
    {
        return Product::class;
    }

    public function getByCategoryId(int $categoryId, array $productIdNotIn = [])
    {
        return $this->product
            ->where('category_id', '=', $categoryId)
            ->whereNotIn('id', $productIdNotIn)
            ->get();
    }
}
