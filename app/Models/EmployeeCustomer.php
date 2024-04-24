<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeCustomer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'employee_customers';

    protected $fillable = [
        'user_id',
        'customer_id',
        'created_by',
        'updated_by',
    ];
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
