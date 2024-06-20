<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SolutionForest\FilamentTree\Concern\ModelTree;

class ProductCategory extends Model
{
    use HasFactory, ModelTree;

    // protected $fillable = ["parent_id", "name", "order_id"];
    protected $table = 'product_categories';
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
    }

    // Define the relationship to the child categories
    public function children(): HasMany 
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }
    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'pivot_product_category', 'category_id', 'product_id');
    }
    public function determineOrderColumnName(): string
    {
        return "order_id";
    }
    public function determineParentColumnName(): string
    {
        return "parent_id";
    }
 
    public function determineTitleColumnName(): string
    {
        return 'name';
    }
 
    public static function defaultParentKey()
    {
        return -1;
    }
 
    public static function defaultChildrenKeyName(): string
    {
        return "children";
    }
}
