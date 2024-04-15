<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'order_id',
        'product_id',
        'product_info',
        'quantity',
        'unit_price',
        'product_price',
        'discount_percent',
        'discount_price',
        'discount_note',
        'note',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function totalProductDelivered() {
        return $this->sum('quantity');
    }
}
