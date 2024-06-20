<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use SolutionForest\FilamentTree\Concern\ModelTree;

class MenuItem extends Model
{
    use HasFactory, ModelTree;
    protected $fillable = ["parent_id", "name", "order_id"];
    protected $table = 'menu_items';
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id', 'id');
    }
    public function children(): HasMany 
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id');
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
