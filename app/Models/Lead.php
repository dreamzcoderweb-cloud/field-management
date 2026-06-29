<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'address',
        'city',
        'product_id',
        'user_id',
        'status',
        'latitude',
        'longitude',
        'email',
        'estimation_amount',
        'delivery_date',
        'our_customer',
        'is_exchangable',
        'model',
        'year',
        'vehicle_number',
        'exchangable_amount',
        'follow_up_date',
        'market_price'        
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function followlead(): HasOne
    {
        return $this->hasOne(Followlead::class);
    }

    protected $casts = [
        'delivery_date' => 'datetime',
        'follow_up_date' => 'date'       
    ];
}

