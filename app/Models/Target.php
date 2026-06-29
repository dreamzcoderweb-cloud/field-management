<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        'team_id',
        "user_id",
        "status",
        "from",
        "to",
    ];

    public function targetproduct(): HasMany
    {
        return $this->hasMany(Targetproduct::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    protected $casts = [
        "from" => "date:Y-m-d",
        "to" => "date:Y-m-d"
    ];
}
