<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Duty extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'title',
        'description',
        'type',
        'notes',
        'assigned_by',
        'start_date',
        'end_date',
        'status',
        'remarks'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedby(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by', 'id');
    }

    public function due(): BelongsTo
    {
        return $this->belongsTo(Due::class, 'id', 'duty_id');
    }

    public function clientmeet(): BelongsTo
    {
        return $this->belongsTo(Clientmeet::class, 'id', 'duty_id');
    }

    protected $cast = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];


    public function getCreatedAtAttribute($createdAt)
    {
        return Carbon::parse($createdAt)->format('d M,Y');
    }

    public function getStartDateAttribute($startDate)
    {
        return Carbon::parse($startDate)->format('d-m-Y');
    }

    public function getEndDateAttribute($endDate)
    {
        return Carbon::parse($endDate)->format('d-m-Y');
    }

    protected $appends = ['status_value'];  // Important for API responses

    public function getStatusValueAttribute(): string
    {
        return match ($this->status ?? -1) {
            0 => "Pending",
            1 => "Completed",
            2 => "Closed",
            3 => "In Progress",
            4 => "Reassign",
            5 => "Hold",
            6 => "Warm",
            7 => "Cold ",
            default => "Unknown",
        };
    }

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class, 'id', 'duty_id');
    }

    public function followlead(): HasOne
    {
        return $this->hasOne(Followlead::class);
    }
}
