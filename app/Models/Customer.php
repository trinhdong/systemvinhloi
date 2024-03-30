<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'area_id',
        'customer_name',
        'email',
        'phone',
        'address',
        'tax_code',
        'company',
        'company_address',
        'shipping_service_address',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function discount()
    {
        return $this->hasMany(Discount::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
