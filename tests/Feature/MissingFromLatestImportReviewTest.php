<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureUserHasRole;
use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\ImportBatch;
use App\Models\ImportBatchSheet;
use App\Models\ImportConflict;
use App\Models\Location;
use App\Models\SalesTransaction;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MissingFromLatestImportReviewTest extends TestCase
{
    private Branch $branch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepareDatabase();

        $businessUnit = BusinessUnit::create([
            'code' => 'L4',
            'name' => 'Lucky 4',
        ]);

        $location = Location::create([
            'code' => 'GSC',
            'name' => 'Gensan',
        ]);

        $this->branch = Branch::create([
            'business_unit_id' => $businessUnit->id,
            'location_id' => $location->id,
            'code' => 'L4GSC',
            'display_name' => 'Lucky 4 Gensan',
            'spreadsheet_sheet_name' => 'L4 GSC',
        ]);

        $this->withoutMiddleware([
            Authenticate::class,
            EnsureEmailIsVerified::class,
            EnsureUserHasRole::class,
        ]);
    }

    public function test_scan_without_previous_comparable_batch_creates_no_conflicts(): void
    {
        $latest = $this->createBatch(importedAt: '2026-05-02 08:00:00');
        $this->createTransaction($latest, [
            'receipt_number' => 'OR-1001',
            'account_number' => 'ACC-1001',
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $latest))
            ->assertRedirect(route('import-batches.show', $latest))
            ->assertSessionHas('warning');

        $this->assertSame(0, ImportConflict::count());
    }

    public function test_previous_transaction_missing_from_latest_creates_audit_conflict(): void
    {
        [$previous, $latest] = $this->createComparableBatches();
        $previousTransaction = $this->createTransaction($previous, [
            'receipt_number' => 'OR-MISSING',
            'account_number' => 'ACC-MISSING',
        ]);
        $this->createTransaction($latest, [
            'receipt_number' => 'OR-LATEST',
            'account_number' => 'ACC-LATEST',
            'invoice_date' => '2026-04-11',
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $latest))
            ->assertRedirect(route('import-batches.show', $latest));

        $conflict = ImportConflict::first();

        $this->assertNotNull($conflict);
        $this->assertSame('missing_from_latest_import', $conflict->conflict_type);
        $this->assertSame('pending', $conflict->status);
        $this->assertSame($latest->id, $conflict->import_batch_id);
        $this->assertSame($previousTransaction->id, $conflict->existing_sales_transaction_id);
    }

    public function test_missing_scan_is_idempotent(): void
    {
        [$previous, $latest] = $this->createComparableBatches();
        $this->createTransaction($previous, [
            'receipt_number' => 'OR-MISSING',
            'account_number' => 'ACC-MISSING',
        ]);
        $this->createTransaction($latest, [
            'receipt_number' => 'OR-LATEST',
            'account_number' => 'ACC-LATEST',
            'invoice_date' => '2026-04-11',
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $latest));
        $this->post(route('import-batches.check-missing-from-latest', $latest));

        $this->assertSame(1, ImportConflict::where('conflict_type', 'missing_from_latest_import')->count());
    }

    public function test_receipt_match_prevents_missing_conflict(): void
    {
        [$previous, $latest] = $this->createComparableBatches();
        $this->createTransaction($previous, [
            'receipt_number' => 'OR-SAME',
            'account_number' => 'ACC-OLD',
        ]);
        $this->createTransaction($latest, [
            'receipt_number' => 'OR-SAME',
            'account_number' => 'ACC-NEW',
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $latest));

        $this->assertSame(0, ImportConflict::count());
    }

    public function test_account_and_invoice_date_match_prevents_missing_conflict(): void
    {
        [$previous, $latest] = $this->createComparableBatches();
        $this->createTransaction($previous, [
            'receipt_number' => 'OR-OLD',
            'account_number' => 'ACC-SAME',
            'invoice_date' => '2026-04-10',
            'promissory_note_amount' => 50000,
        ]);
        $this->createTransaction($latest, [
            'receipt_number' => 'OR-NEW',
            'account_number' => 'ACC-SAME',
            'invoice_date' => '2026-04-10',
            'promissory_note_amount' => 70000,
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $latest));

        $this->assertSame(0, ImportConflict::count());
    }

    public function test_account_date_and_effective_amount_match_prevents_missing_conflict(): void
    {
        [$previous, $latest] = $this->createComparableBatches();
        $this->createTransaction($previous, [
            'receipt_number' => null,
            'account_number' => 'ACC-AMOUNT',
            'invoice_date' => '2026-04-10',
            'promissory_note_amount' => 85000,
        ]);
        $this->createTransaction($latest, [
            'receipt_number' => null,
            'account_number' => 'ACC-AMOUNT',
            'invoice_date' => '2026-04-10',
            'promissory_note_amount' => 85000,
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $latest));

        $this->assertSame(0, ImportConflict::count());
    }

    public function test_invoice_date_alone_does_not_prevent_missing_conflict(): void
    {
        [$previous, $latest] = $this->createComparableBatches();
        $previousTransaction = $this->createTransaction($previous, [
            'receipt_number' => 'OR-OLD',
            'account_number' => 'ACC-OLD',
            'invoice_date' => '2026-04-10',
            'promissory_note_amount' => 85000,
        ]);
        $this->createTransaction($latest, [
            'receipt_number' => 'OR-NEW',
            'account_number' => 'ACC-NEW',
            'invoice_date' => '2026-04-10',
            'promissory_note_amount' => 99000,
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $latest));

        $this->assertSame(1, ImportConflict::count());
        $this->assertSame($previousTransaction->id, ImportConflict::first()->existing_sales_transaction_id);
    }

    public function test_row_count_guard_skips_mass_missing_conflicts(): void
    {
        [$previous, $latest] = $this->createComparableBatches();

        foreach (range(1, 4) as $index) {
            $this->createTransaction($previous, [
                'receipt_number' => "OR-PREV-{$index}",
                'account_number' => "ACC-PREV-{$index}",
                'invoice_date' => "2026-04-1{$index}",
            ]);
        }

        $this->createTransaction($latest, [
            'receipt_number' => 'OR-LATEST-1',
            'account_number' => 'ACC-LATEST-1',
            'invoice_date' => '2026-04-11',
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $latest))
            ->assertSessionHas('warning');

        $this->assertSame(0, ImportConflict::count());
    }

    public function test_non_imported_batch_cannot_run_missing_review(): void
    {
        $batch = $this->createBatch(status: 'uploaded', importedAt: null);
        $this->createTransaction($batch, [
            'receipt_number' => 'OR-UPLOADED',
            'account_number' => 'ACC-UPLOADED',
        ]);

        $this->post(route('import-batches.check-missing-from-latest', $batch))
            ->assertSessionHas('warning');

        $this->assertSame(0, ImportConflict::count());
    }

    private function createComparableBatches(): array
    {
        return [
            $this->createBatch(importedAt: '2026-05-01 08:00:00'),
            $this->createBatch(importedAt: '2026-05-02 08:00:00'),
        ];
    }

    private function createBatch(string $status = 'imported', ?string $importedAt = '2026-05-01 08:00:00'): ImportBatch
    {
        return ImportBatch::create([
            'uploaded_by' => 1,
            'original_filename' => 'test.xlsx',
            'stored_filename' => 'imports/test.xlsx',
            'source_type' => 'manual_upload',
            'status' => $status,
            'imported_at' => $importedAt,
        ]);
    }

    private function createTransaction(ImportBatch $batch, array $overrides = []): SalesTransaction
    {
        $sheet = ImportBatchSheet::firstOrCreate([
            'import_batch_id' => $batch->id,
            'branch_id' => $this->branch->id,
            'sheet_name' => 'L4 GSC',
        ], [
            'sheet_type' => 'transaction',
            'status' => 'imported',
        ]);

        return SalesTransaction::create(array_merge([
            'import_batch_id' => $batch->id,
            'import_batch_sheet_id' => $sheet->id,
            'branch_id' => $this->branch->id,
            'invoice_date' => '2026-04-10',
            'account_number' => 'ACC-1001',
            'customer_name' => 'Test Customer',
            'receipt_number' => 'OR-1001',
            'product' => 'Brand New',
            'product_line_name' => 'MOTORCYCLE',
            'brand_name_raw' => 'HONDA',
            'model' => 'CLICK 125',
            'promissory_note_amount' => 100000,
            'cash_amount' => null,
            'gross_sales_amount' => null,
            'srp_cod_amount' => null,
            'amount' => 100000,
            'source_row_number' => 4,
            'raw_row_data' => ['row' => 'snapshot'],
        ], $overrides));
    }

    private function prepareDatabase(): void
    {
        Schema::dropIfExists('import_conflicts');
        Schema::dropIfExists('sales_transactions');
        Schema::dropIfExists('import_batch_sheets');
        Schema::dropIfExists('import_batches');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('business_units');

        Schema::create('business_units', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_unit_id');
            $table->foreignId('location_id');
            $table->string('code')->unique();
            $table->string('display_name');
            $table->string('spreadsheet_sheet_name')->nullable();
            $table->timestamps();
        });

        Schema::create('import_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_by');
            $table->string('original_filename');
            $table->string('stored_filename')->nullable();
            $table->string('source_type')->nullable();
            $table->unsignedInteger('total_sheets')->default(0);
            $table->unsignedInteger('supported_sheets')->default(0);
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('valid_rows')->default(0);
            $table->unsignedInteger('invalid_rows')->default(0);
            $table->unsignedInteger('duplicate_rows')->default(0);
            $table->unsignedInteger('conflict_rows')->default(0);
            $table->unsignedInteger('imported_rows')->default(0);
            $table->unsignedInteger('skipped_rows')->default(0);
            $table->string('status')->default('uploaded');
            $table->text('notes')->nullable();
            $table->timestamp('imported_at')->nullable();
            $table->timestamps();
        });

        Schema::create('import_batch_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('branch_id')->nullable();
            $table->string('sheet_name');
            $table->string('sheet_type')->default('unsupported');
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('valid_rows')->default(0);
            $table->unsignedInteger('invalid_rows')->default(0);
            $table->unsignedInteger('duplicate_rows')->default(0);
            $table->unsignedInteger('conflict_rows')->default(0);
            $table->unsignedInteger('imported_rows')->default(0);
            $table->unsignedInteger('skipped_rows')->default(0);
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('import_batch_sheet_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('account_number')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('product')->nullable();
            $table->string('product_line_name')->nullable();
            $table->string('brand_name_raw')->nullable();
            $table->string('model')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('srp_cod_amount', 15, 2)->nullable();
            $table->decimal('cash_amount', 15, 2)->nullable();
            $table->decimal('promissory_note_amount', 15, 2)->nullable();
            $table->decimal('gross_sales_amount', 15, 2)->nullable();
            $table->unsignedInteger('source_row_number')->nullable();
            $table->json('raw_row_data')->nullable();
            $table->string('row_hash', 64)->nullable();
            $table->string('match_key', 64)->nullable();
            $table->timestamps();
        });

        Schema::create('import_conflicts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('import_batch_sheet_id')->nullable();
            $table->foreignId('existing_sales_transaction_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->string('conflict_type')->nullable();
            $table->unsignedInteger('source_row_number')->nullable();
            $table->string('match_key', 64)->index();
            $table->string('new_row_hash', 64)->nullable();
            $table->json('existing_row_data')->nullable();
            $table->json('incoming_row_data')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
}
