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
        'order_total_product_price',
        'status',
        'order_date',
        'shipping_address',
        'order_note',
        'deposit',
        'payment_type',
        'is_print_red_invoice',
        'payment_method',
        'bank_code',
        'bank_name',
        'bank_customer_name',
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
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
