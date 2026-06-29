<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Due extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'duty_id',
        'client_id',
        'amount'
    ];

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class, 'id', 'sale_id');
    }

    public function duty(): HasOne
    {
        return $this->hasOne(Duty::class,'id','duty_id');
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
}
