<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'client_id',
        'bank_id',
        'amount',
        'payment_method',
        'product_amount',
        'paid_amount',
        'balance',
        'interest',
        'is_exchangable',
        'exchangable_item',
        'exchangable_amount',
        'vehicle_number',
        'vehicle_year',
        'paid_advance',
        'advance_amont',
        'emi_applicable',
        'emi_amount',
        'emi_month',
        'emi_date',
        'is_completed',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
    public function collections()
    {
       return $this->hasMany(SaleCollection::class, 'sale_id', 'id');
    }
    public function advance(): HasMany
    {
        return $this->hasMany(Advance::class);
    }

    public function due(): HasMany
    {
        return $this->hasMany(Due::class, 'sale_id', 'id');
    }

    public function duty(): BelongsTo
    {
        return $this->belongsTo(Duty::class, 'duty_id', 'id');
    }

    public function ledger(): HasOne
    {
        return $this->hasOne(Ledger::class);
    }
    public function saleProducts(): HasMany
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function collection(): HasOne
    {
        return $this->hasOne(SaleCollection::class);
    }
}
