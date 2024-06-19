<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    use HasFactory;
    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class, 'pivot_variant_attribute');
    }

    public function option(): BelongsTo
    {
        return $this->BelongsTo(Option::class);
    }
}
