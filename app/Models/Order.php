<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'areas';
    protected $fillable = [
        'customer_id',
        'order_number',
        'order_total',
        'status',
        'order_date',
        'shipping_address',
        'shipping_service_address',
        'note',
        'payment_method',
        'payment_date',
        'payment_status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];
}
