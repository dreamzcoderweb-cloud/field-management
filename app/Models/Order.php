<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'client_id',
        'order_no',
        'total',
        'discount',
        'tax',
        'grand_total',
        'quantity',
        'notes',
        'user_remarks',
        'admin_remarks',
        'cancel_remarks',
        'processed_by_id',
        'processed_at',
        'completed_by_id',
        'completed_at',
        'cancelled_by_id',
        'cancelled_at',
        'product_id',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'total' => 'float',
        'discount' => 'float',
        'tax' => 'float',
        'grand_total' => 'float',
    ];


}
