<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'brand_id',
        'name',
        'description',
        'parent_id',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function productsubcategory(): HasMany
    {

        return $this->hasMany(ProductSubcategory::class, 'product_category_id');
    }

    public function client(): HasMany
    {
        return $this->hasMany(Client::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
