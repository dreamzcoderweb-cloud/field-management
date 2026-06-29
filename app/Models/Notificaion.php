<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaion extends Model
{
    use HasFactory;

    protected $table = 'notifications';


    protected $fillable = [
        'title',
        'description',
        'img_url',
        'is_read',
        'from_user_id',
        'to_user_id',
        'team_id',
        'type',
        'created_by_id',
        'updated_by_id',
    ];
/*
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }*/

}
