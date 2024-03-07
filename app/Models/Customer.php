<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'areas';
    protected $fillable = [
        'area_id',
        'customer_name',
        'email',
        'phone',
        'address',
        'shipping_service_address',
        'created_by',
        'updated_by',
    ];
}
