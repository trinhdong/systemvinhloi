<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'product_code',
        'product_name',
        'price',
        'description',
        'color',
        'capacity',
        'unit',
        'specifications',
        'quantity_per_package',
        'image_url',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function product()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function discount()
    {
        return $this->hasMany(Discount::class);
    }
}
