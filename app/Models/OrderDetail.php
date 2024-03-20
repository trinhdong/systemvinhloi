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
        'quantity',
        'unit_price',
        'note',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
