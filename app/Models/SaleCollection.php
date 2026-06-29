<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleCollection extends Model
{
    use HasFactory;

    protected $table = 'collections';

    protected $fillable = [
        'client_id',
        'sale_id',
        'product_id',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'emi_amount',
        'emi_date',
        'total_months',
        'paid_months',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(CollectionTransaction::class, 'collection_id');
    }
    public function collectionTransactions()
    {
        return $this->hasMany(CollectionTransaction::class, 'collection_id', 'id');
    }
    protected $casts = [
        'total_amount' => 'double',
        'paid_amount' => 'double',
        'balance_amount' => 'double',
        'emi_amount' => 'double',
    ];
}
