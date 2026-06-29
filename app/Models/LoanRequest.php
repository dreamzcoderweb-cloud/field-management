<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;

    protected $table = 'loan_requests';

    protected $fillable = [
        'user_id',
        'amount',
        'approved_amount',
        'action_taken_by_id',
        'action_taken_at',
        'action_taken_remarks',
        'remarks',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
