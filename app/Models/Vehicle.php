<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "vehicle_number",
        "status"
    ];

    public function vehiclemanagement(): HasMany
    {
        return $this->hasMany(Vehiclemanagement::class);
    }
}
