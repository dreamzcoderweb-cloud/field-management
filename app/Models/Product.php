<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'product_type',
        'description',
        'product_code',
        'status',
        'brand_id',
        'category_id',
        'subcategory_id',
        'base_price',
        'discount',
        'tax',
        'price',
        'stock',
        'images',
        'thumbnail',
        'created_by_id',
        'updated_by_id',
        'english',
        'tamil'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id');
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function orderLines()
    {
        return $this->hasMany(OrderLine::class, 'product_id');
    }

    public function client(): HasMany
    {
        return $this->hasMany(Client::class, 'product_id');
    }

    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function collections(): HasMany
    {
        return $this->hasMany(SaleCollection::class, 'product_id', 'id');
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }

    public function stockhistory(): HasMany
    {
        return $this->hasMany(Stockhistory::class, 'product_id', 'id');
    }

    public function lead(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function targetproduct(): HasOne
    {
        return $this->hasOne(Targetproduct::class);
    }

    protected $casts = [
        'price' => 'double',
        'base_price' => 'double',
    ];
}
