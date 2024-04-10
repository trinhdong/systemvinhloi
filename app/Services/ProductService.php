<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

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

    public function searchQuery($query, $request = [])
    {
        $filters = [
            'product_name' => [
                'logical_operator' => 'AND',
                'operator' => 'LIKE',
                'value' => $query . '%'
            ],
        ];
        $categoryId = intval($request['category_id'] ?? 0);
        $productIdsNotIn = $request['productIdsNotIn'] ?? [];
        if (!empty($categoryId)) {
            $filters['category_id'] = $categoryId;
        }
        if (!empty($productIdsNotIn)) {
            $filters['id'] = [
                'logical_operator' => 'AND',
                'operator' => 'NOT IN',
                'value' => array_map('intval', $productIdsNotIn)
            ];
        }

        return $this->paginate($filters, 'id');
    }

    /**
     * @throws \Exception
     */
    public function storeProductService($data)
    {
        try {
            return $this->productRepository->storeProductRepository($data);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lưu sản phẩm: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $data
            ]);
            throw $e;
        }
    }
    public function updateProductService($data)
    {
        try {
            return $this->productRepository->updateProductRepository($data);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật sản phẩm: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $data
            ]);
            throw $e;
        }
    }
}
