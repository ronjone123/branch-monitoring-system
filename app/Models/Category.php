<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'product_line_id',
        'code',
        'name',
        'status',
    ];

    public function productLine(): BelongsTo
    {
        return $this->belongsTo(ProductLine::class);
    }
}