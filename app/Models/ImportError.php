<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportError extends Model
{
    protected $fillable = [
        'import_batch_id',
        'import_batch_sheet_id',
        'sheet_name',
        'row_number',
        'field_name',
        'error_message',
        'raw_payload',
    ];

    public function importBatch(): BelongsTo
    {
        return $this->belongsTo(ImportBatch::class);
    }

    public function sheet(): BelongsTo
    {
        return $this->belongsTo(ImportBatchSheet::class, 'import_batch_sheet_id');
    }
}