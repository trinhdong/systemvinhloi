<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_name',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
