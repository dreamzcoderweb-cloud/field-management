<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseRequest extends Model
{
    use HasFactory;

    protected $table = 'expense_requests';

    protected $fillable = [
        'expense_type_id',
        'user_id',
        'amount',
        'comments',
        'document',
        'approved_by_id',
        'approved_at',
        'status',
        'remarks',
        'approver_remarks',
        'for_date',
    ];


    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'approved_at' => 'datetime'
    ];

}
