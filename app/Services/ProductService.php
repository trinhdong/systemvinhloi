<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService extends BaseService
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->setRepository();
    }

    public function getRepository()
    {
        return ProductRepository::class;
    }

    public function getByCategoryId(int $categoryId, array $productIdNotIn = [])
    {
        return $this->productRepository->getByCategoryId($categoryId, $productIdNotIn);
    }
}
