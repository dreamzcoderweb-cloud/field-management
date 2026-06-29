<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $table = 'order_lines';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'discount',
        'tax',
        'notes',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'total' => 'float',
        'price' => 'float',
        'discount' => 'float',
        'tax' => 'float',
    ];
}
