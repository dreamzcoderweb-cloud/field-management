<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    public function client(): HasMany
    {
        return $this->hasMany(Client::class, 'bank_id');
    }

    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    protected $fillable = ['user_id', 'name', 'status'];
}
