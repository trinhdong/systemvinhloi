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
        'has_print_red_invoice',
        'has_update_quantity',
        'payment_method',
        'bank_account_id',
        'bank_account_info',
        'payment_due_day',
        'bank_code',
        'bank_name',
        'bank_customer_name',
        'payment_date',
        'delivery_appointment_date',
        'payment_status',
        'payment_check_type',
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
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function delivered()
    {
        return $this->hasOne(Comment::class)->where('order_id', $this->id)->where('status', DELIVERED);
    }
    public function inProcessing()
    {
        return $this->hasOne(Comment::class)->where('order_id', $this->id)->where('status', IN_PROCESSING);
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
            case STOCKER:
                return $this->enableButtonByStatus(false, false, true);
                break;
            case ACCOUNTANT:
                return $this->enableButtonByStatus();
                break;
            default:
                return $this->enableButtonByStatus();
                break;
        }
    }
    private function enableButtonByStatus($edit = true, $delete = true, $view = true) {
        $listbutton = [
            'edit' => false,
            'view' => true,
            'delete' => false,
        ];
        switch($this->status) {
            case DRAFT;
            case REJECTED;
                $listbutton = [
                    'edit' => $edit,
                    'view' => $view,
                    'delete' => $delete,
                ];
                break;
            case DELIVERED;
            case IN_PROCESSING;
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
