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

    public function storeProductRepository($data)
    {
        if ($data->hasFile('image_url')) {
            $file = $data->file('image_url');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images/products', $filename, 'public');
            $imagePath = '/storage/' . $filePath;
        } else {
            $imagePath = null;
        }
        $productData = $data->except(['image_url']);
        $productData['image_url'] = $imagePath;

        return $this->create($productData);
    }
    public function updateProductRepository($data)
    {
        $product = $this->model->find($data['id']);
        $productData = $data->except(['image_url']);
        if ($data->hasFile('image_url')) {
            $file = $data->file('image_url');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('images/products', $filename, 'public');
            $productData['image_url'] = '/storage/' . $filePath;
        } else {
            $productData['image_url'] = $product->image_url;
        }
        return $this->update($data['id'], $productData);
    }
}
