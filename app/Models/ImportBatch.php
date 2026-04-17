<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportBatch extends Model
{
    protected $fillable = [
        'uploaded_by',
        'original_filename',
        'stored_filename',
        'source_type',
        'total_sheets',
        'supported_sheets',
        'total_rows',
        'valid_rows',
        'invalid_rows',
        'imported_rows',
        'skipped_rows',
        'status',
        'notes',
        'imported_at',
    ];

    protected $casts = [
        'imported_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function sheets(): HasMany
    {
        return $this->hasMany(ImportBatchSheet::class);
    }

    public function errors(): HasMany
    {
        return $this->hasMany(ImportError::class);
    }
    public function transactions()
    {
        return $this->hasMany(SalesTransaction::class);
    }
}