<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    protected $fillable = [
        'business_unit_id',
        'location_id',
        'code',
        'display_name',
        'area_barangay',
        'spreadsheet_sheet_name',
        'status',
        'opened_at',
        'closed_at',
        'remarks',
    ];

    protected $casts = [
        'opened_at' => 'date',
        'closed_at' => 'date',
    ];

    public function businessUnit(): BelongsTo
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function allowedProductLines(): HasMany
    {
        return $this->hasMany(BranchAllowedProductLine::class);
    }

    public function productLines(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductLine::class,
            'branch_allowed_product_lines'
        )->withTimestamps();
    }
}