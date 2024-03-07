<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'areas';
    protected $fillable = [
        'product_id',
        'customer_id',
        'discount_percent',
        'created_by',
        'updated_by',
    ];
}
