<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'order_id',
        'customer_id',
        'sale_id',
        'pdf_invoice_path',
        'pdf_delivery_bill_path',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
