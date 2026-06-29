<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCollection extends Model
{
    use HasFactory;

    protected $table = 'payment_collections';

    protected $fillable = [
        'user_id',
        'client_id',
        'payment_mode',
        'amount',
        'remarks',
        'proof_url',
        'created_by_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
