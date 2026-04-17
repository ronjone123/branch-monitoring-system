<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductLine extends Model
{
    protected $fillable = [
        'code',
        'name',
        'status',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(
            Branch::class,
            'branch_allowed_product_lines'
        )->withTimestamps();
    }
    
}