<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesTransaction extends Model
{
    protected $fillable = [
        'import_batch_id',
        'import_batch_sheet_id',
        'branch_id',
        'invoice_date',
        'account_number',
        'customer_name',
        'contact_number',
        'birth_date',
        'address',
        'sales_type',
        'agent_referral_name',
        'transaction_type',
        'receipt_number',
        'sales_source',
        'product',
        'amount',
        'terms',
        'branch_name_from_sheet',
        'pouching_date',
        'encoded_by',
        'date_last_updated',
        'source_row_number',
        'raw_row_data',
        'unit_type',
        'product_line_name',
        'category_name_raw',
        'brand_name_raw',
        'model',
        'capacity',
        'product_description',
        'serial_number',
        'engine_number',
        'chassis_number',
        'parts_number',
        'color',
        'stock_code',
        'product_remarks',
        'srp_cod_amount',
        'cash_amount',
        'downpayment_amount',
        'promissory_note_amount',
        'gross_sales_amount',
        'commission_amount',
        'monthly_amortization',
        'street_address',
        'city_municipality',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'birth_date' => 'date',
        'pouching_date' => 'date',
        'date_last_updated' => 'date',
        'amount' => 'decimal:2',
        'raw_row_data' => 'array',
    ];

    public function importBatch(): BelongsTo
    {
        return $this->belongsTo(ImportBatch::class);
    }

    public function importBatchSheet(): BelongsTo
    {
        return $this->belongsTo(ImportBatchSheet::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}