<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'latitude',
        'longitude',
        'contact_person_name',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'category_id',
        'subcategory_id',
        'product_id',
        'bank_id',

        'radius',
        'city',
        'state',
        'remarks',
        'image_url',
        'status',
        'created_by_id',
    ];

    public function sites()
    {
        return $this->hasMany(Site::class, 'client_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'client_id', 'id');
    }

    public function forms()
    {
        return $this->hasMany(Form::class, 'client_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function Sale(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function clientmeet(): BelongsTo
    {
        return $this->belongsTo(Clientmeet::class, 'clientmeet_id', 'id');
    }

    public function due(): BelongsTo
    {
        return $this->belongsTo(Due::class, 'client_id', 'id');
    }
    
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }
}
