<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $fillable = [
        'name',
        'description',
        'status',
        'is_chat_enabled',
        'created_by_id',
        'updated_by_id',
    ];

    public function target(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function task(): HasMany
    {
        return $this->hasMany(Duty::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'team_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'team_id');
    }
}
