<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehiclemanagement extends Model
{
    use HasFactory;

    protected $fillable = [
        "vehicle_id",
        "driver_name",
        "distance",
        "fuel",
        "location",
        "notes"
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
