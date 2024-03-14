<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->setModel();
    }

    public function getModel()
    {
        return Category::class;
    }
}
