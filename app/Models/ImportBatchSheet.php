<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportBatchSheet extends Model
{
    protected $fillable = [
        'import_batch_id',
        'branch_id',
        'sheet_name',
        'sheet_type',
        'total_rows',
        'valid_rows',
        'invalid_rows',
        'imported_rows',
        'skipped_rows',
        'status',
        'notes',
    ];

    public function importBatch(): BelongsTo
    {
        return $this->belongsTo(ImportBatch::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function errors(): HasMany
    {
        return $this->hasMany(ImportError::class, 'import_batch_sheet_id');
    }
    public function transactions()
    {
        return $this->hasMany(SalesTransaction::class, 'import_batch_sheet_id');
    }
}