<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportConflict extends Model
{
    protected $fillable = [
        'import_batch_id',
        'import_batch_sheet_id',
        'existing_sales_transaction_id',
        'branch_id',
        'source_row_number',
        'match_key',
        'new_row_hash',
        'existing_row_data',
        'incoming_row_data',
        'status',
        'notes',
    ];

    protected $casts = [
        'existing_row_data' => 'array',
        'incoming_row_data' => 'array',
    ];

    public function importBatch(): BelongsTo
    {
        return $this->belongsTo(ImportBatch::class);
    }

    public function importBatchSheet(): BelongsTo
    {
        return $this->belongsTo(ImportBatchSheet::class);
    }

    public function existingSalesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'existing_sales_transaction_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}