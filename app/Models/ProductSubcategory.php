<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSubcategory extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = ['product_category_id','name','status'];


    public function productcategory():BelongsTo{

        return $this->belongsTo(ProductCategory::class, 'product_category_id');

    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    public function client():HasMany{
        return $this->hasMany(Client::class,'subcategory_id');
    }
}
