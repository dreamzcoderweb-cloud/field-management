<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';

    protected $fillable = [
        'from_date',
        'to_date',
        'leave_type_id',
        'user_id',
        'remarks',
        'document',
        'approved_by',
        'approved_at',
        'status',
        'approver_remarks'
    ];

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
