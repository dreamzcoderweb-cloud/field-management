<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Staffvehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bike_model',
        'number',
        'current_kilometer',
        'kilometer_image',
        'type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

