<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeofenceLocation extends Model
{
    use HasFactory;

    protected $table = 'geofence_locations';

    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'radius',
        'is_enabled',
        'geofence_group_id',
        'created_by_id',
        'updated_by_id',
    ];

    public function geofenceGroup()
    {
        return $this->belongsTo(GeofenceGroup::class);
    }
}
