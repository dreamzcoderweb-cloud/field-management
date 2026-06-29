<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Targetproduct extends Model
{
    use HasFactory;

    protected $fillable = [
        "target_id",
        "product_id",
        "is_completed",
        "incentive"
    ];

    public function target(): BelongsTo
    {
        return $this->belongsTo(Target::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
