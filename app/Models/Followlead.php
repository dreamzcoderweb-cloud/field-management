<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Followlead extends Model
{
    use HasFactory;

    protected $fillable = [
        "lead_id",
        "duty_id"
    ];

    public function  lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function duty(): BelongsTo
    {
        return $this->belongsTo(Duty::class);
    }
}
