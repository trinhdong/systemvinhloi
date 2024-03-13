<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'areas';
    protected $fillable = [
        'category_id',
        'product_code',
        'product_name',
        'price',
        'quantity',
        'description',
        'attributes',
        'unit',
        'image_url',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
