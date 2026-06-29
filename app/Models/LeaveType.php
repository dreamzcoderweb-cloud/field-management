<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table = 'leave_types';

    protected $fillable = [
        'name',
        'description',
        'is_img_required',
        'status'
    ];

    public function leaveRequest()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
