<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'client_id',
        'sale_id',
        'product_id',
        'amount',
        'payment_date',
        'emi_month',
        'notes',
        'created_by_id',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(SaleCollection::class, 'collection_id');
    }

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

    protected $casts = [
        'amount' => 'double',
        'payment_date' => 'date',
    ];
}
