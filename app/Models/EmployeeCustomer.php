<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeCustomer extends Model
{
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
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
