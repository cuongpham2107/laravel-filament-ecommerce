<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'tags' => 'array',
        'images' => 'array'
    ];

    public function categories(): BelongsToMany {
        return $this->belongsToMany(ProductCategory::class, 'pivot_product_category', 'product_id', 'category_id');
    }

    public function brand(): BelongsTo {
        return $this->belongsTo(ProductBrand::class);
    }
    
    public function variants():HasMany
    {
        return $this->hasMany(Variant::class);    
    }
}
