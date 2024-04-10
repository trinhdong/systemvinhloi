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
        'image_url',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function discount()
    {
        return $this->hasMany(Discount::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
