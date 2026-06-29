<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    use HasFactory;

    protected $table = 'sales_targets';

    protected $fillable = [
        'user_id',
        'period',
        'target',
        'archived',
        'balance',
        'percentage',
        'incentive',
        'remarks',
        'created_by_id',
        'updated_by_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
