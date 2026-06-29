<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $table = 'document_requests';

    protected $fillable = [
        'remarks',
        'document_type_id',
        'user_id',
        'status',
        'approver_remarks',
        'generated_file',
        'action_taken_by_id',
        'action_taken_at',
        'created_by_id',
        'updated_by_id',
    ];

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $casts = [
        'action_taken_at' => 'datetime',
    ];


}
