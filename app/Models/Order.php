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
        'customer_info',
        'shipping_address',
        'order_note',
        'deposit',
        'paid',
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

    public function enableButtonByRole($role) {
        switch ($role) {
            case SUPER_ADMIN:
                return $this->enableButtonByStatus();
                break;
            case ADMIN:
                return $this->enableButtonByStatus();
                break;
            case SALE:
                return $this->enableButtonByStatus();
                break;
            case WAREHOUSE_STAFF:
                return $this->enableButtonByStatus();
                break;
            case ACCOUNTANT:
                return $this->enableButtonByStatus();
                break;
            default:
                return $this->enableButtonByStatus();
                break;
        }
    }
    private function enableButtonByStatus() {
        $listbutton = [
            'edit' => false,
            'view' => false,
            'delete' => false,
        ];
        switch($this->status) {
            case DRAFT;
            case REJECTED;
                $listbutton = [
                    'edit' => true,
                    'view' => true,
                    'delete' => true,
                ];
                break;
            case AWAITING;
            case DELIVERED;
            case CONFIRMED;
            case DELIVERY;
            case COMPLETE;
                $listbutton = [
                    'edit' => false,
                    'view' => true,
                    'delete' => false,
                ];
                break;
        }

        return $listbutton;
    }
}
