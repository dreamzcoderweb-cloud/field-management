<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Clientmeet extends Model
{
    use HasFactory;

    protected $fillable = [
        'duty_id',
        'client_id',
        'next_meet'
    ];

    public function duty(): HasOne
    {
        return $this->hasOne(Duty::class, 'id', 'duty_id');
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }


    protected $casts = [
        "next_meet" => "datetime"
    ];
}

