<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'customer_id',
        'order_number',
        'order_total',
        'order_discount',
        'status',
        'order_date',
        'shipping_address',
        'note',
        'payment_method',
        'payment_date',
        'payment_status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
