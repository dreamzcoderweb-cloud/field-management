<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    use HasFactory;

    protected $table = 'expense_types';

    protected $fillable = [
        'name',
        'description',
        'is_img_required',
        'status',
    ];

    public function expenseRequests()
    {
        return $this->hasMany(ExpenseRequest::class, 'expense_type_id');
    }
}
