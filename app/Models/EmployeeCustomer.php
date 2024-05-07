<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class EmployeeCustomer extends Model
{
    use HasFactory;
    protected $table = 'employee_customers';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($employeeCustomer) {
            $employeeCustomer->created_by = Auth::user()->id;
        });

        static::updating(function ($employeeCustomer) {
            $employeeCustomer->updated_by = Auth::user()->id;
        });
    }

    protected $fillable = [
        'user_id',
        'customer_id',
        'created_by',
        'updated_by',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
