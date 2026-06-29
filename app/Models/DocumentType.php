<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'document_types';

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    public function documentRequest()
    {
        return $this->hasMany(DocumentRequest::class);

    }
}
