<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\ImportBatch;
use App\Models\ImportBatchSheet;
use App\Models\ImportConflict;
use App\Models\Location;
use App\Models\SalesTransaction;
use App\Models\User;
use App\Services\Import\TransactionSheetParser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class IncompleteTransactionMatchingTest extends TestCase
{
    private User $user;
    private Branch $branch;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'import.valid_product_lines' => ['MOTORCYCLE', 'APPLIANCE'],
            'import.known_brands' => ['HONDA', 'YAMAHA', 'SAMSUNG'],
        ]);

        Storage::fake('local');
        $this->prepareDatabase();

        $this->user = User::create([
            'name' => 'Test Importer',
            'email' => 'importer@example.test',
            'password' => 'password',
        ]);

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
    }

    private function prepareDatabase(): void
    {
        Schema::dropIfExists('import_conflicts');
        Schema::dropIfExists('import_errors');
        Schema::dropIfExists('sales_transactions');
        Schema::dropIfExists('import_batch_sheets');
        Schema::dropIfExists('import_batches');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('business_units');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('business_units', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('city_or_municipality')->nullable();
            $table->string('province')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_unit_id');
            $table->foreignId('location_id');
            $table->string('code')->unique();
            $table->string('display_name');
            $table->string('area_barangay')->nullable();
            $table->string('spreadsheet_sheet_name')->nullable();
            $table->string('status')->default('active');
            $table->date('opened_at')->nullable();
            $table->date('closed_at')->nullable();
            $table->text('remarks')->nullable();
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
            $table->string('contact_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('street_address')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('sales_type')->nullable();
            $table->string('agent_referral_name')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('sales_source')->nullable();
            $table->string('product')->nullable();
            $table->string('unit_type')->nullable();
            $table->string('product_line_name')->nullable();
            $table->string('category_name_raw')->nullable();
            $table->string('brand_name_raw')->nullable();
            $table->string('model')->nullable();
            $table->string('capacity')->nullable();
            $table->text('product_description')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('parts_number')->nullable();
            $table->string('color')->nullable();
            $table->string('stock_code')->nullable();
            $table->text('product_remarks')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('srp_cod_amount', 15, 2)->nullable();
            $table->decimal('cash_amount', 15, 2)->nullable();
            $table->decimal('downpayment_amount', 15, 2)->nullable();
            $table->decimal('promissory_note_amount', 15, 2)->nullable();
            $table->decimal('gross_sales_amount', 15, 2)->nullable();
            $table->decimal('commission_amount', 15, 2)->nullable();
            $table->decimal('monthly_amortization', 15, 2)->nullable();
            $table->string('terms')->nullable();
            $table->string('branch_name_from_sheet')->nullable();
            $table->date('pouching_date')->nullable();
            $table->string('encoded_by')->nullable();
            $table->date('date_last_updated')->nullable();
            $table->unsignedInteger('source_row_number')->nullable();
            $table->json('raw_row_data')->nullable();
            $table->string('row_hash', 64)->nullable();
            $table->string('match_key', 64)->nullable();
            $table->timestamps();
        });

        Schema::create('import_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('import_batch_sheet_id')->nullable();
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

    public function test_completed_account_number_creates_conflict_instead_of_duplicate_sale(): void
    {
        $this->createOldIncompleteTransaction();

        $sheet = $this->parseWorkbookRow($this->row([
            'account_number' => 'ACC-1001',
        ]));

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame(0, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(1, (int) $sheet->fresh()->conflict_rows);
        $this->assertSame('completeness_conflict', ImportConflict::first()->conflict_type);
        $this->assertSame(SalesTransaction::first()->id, ImportConflict::first()->existing_sales_transaction_id);
    }

    public function test_completed_unit_identifier_creates_conflict_instead_of_duplicate_sale(): void
    {
        $this->createOldIncompleteTransaction();

        $sheet = $this->parseWorkbookRow($this->row([
            'engine_number' => 'ENG-1001',
            'chassis_number' => 'CHS-1001',
        ]));

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame(0, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(1, (int) $sheet->fresh()->conflict_rows);
        $this->assertSame('completeness_conflict', ImportConflict::first()->conflict_type);
    }

    public function test_same_branch_and_date_alone_does_not_merge_different_transactions(): void
    {
        $this->createOldIncompleteTransaction([
            'model' => 'CLICK 125',
            'cash_amount' => 100000,
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'model' => 'MIO 125',
            'cash_amount' => 88000,
            'amount' => 88000,
        ]));

        $this->assertSame(2, SalesTransaction::count());
        $this->assertSame(1, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(0, ImportConflict::count());
    }

    public function test_same_branch_date_but_different_amount_does_not_fallback_match(): void
    {
        $this->createOldIncompleteTransaction([
            'cash_amount' => 100000,
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'cash_amount' => 120000,
            'amount' => 120000,
        ]));

        $this->assertSame(2, SalesTransaction::count());
        $this->assertSame(1, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(0, ImportConflict::count());
    }

    public function test_same_branch_date_amount_but_different_product_does_not_fallback_match(): void
    {
        $this->createOldIncompleteTransaction([
            'model' => 'CLICK 125',
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'model' => 'MIO 125',
        ]));

        $this->assertSame(2, SalesTransaction::count());
        $this->assertSame(1, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(0, ImportConflict::count());
    }

    public function test_product_line_only_does_not_create_fallback_match(): void
    {
        $this->createOldIncompleteTransaction([
            'product' => null,
            'model' => null,
            'product_description' => null,
            'parts_number' => null,
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'account_number' => 'ACC-1001',
            'product' => null,
            'model' => null,
            'product_description' => null,
            'parts_number' => null,
        ]));

        $this->assertSame(2, SalesTransaction::count());
        $this->assertSame(1, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(0, (int) $sheet->fresh()->conflict_rows);
        $this->assertSame(0, ImportConflict::count());
    }

    public function test_multiple_fallback_candidates_create_ambiguous_conflict_without_insert(): void
    {
        $this->createOldIncompleteTransaction();
        $this->createOldIncompleteTransaction([
            'customer_name' => 'Another Customer',
            'source_row_number' => 7,
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'account_number' => 'ACC-1001',
        ]));

        $this->assertSame(2, SalesTransaction::count());
        $this->assertSame(0, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(1, (int) $sheet->fresh()->conflict_rows);
        $this->assertSame('ambiguous_account_conflict', ImportConflict::first()->conflict_type);
        $this->assertNull(ImportConflict::first()->existing_sales_transaction_id);
    }

    public function test_exact_duplicate_behavior_remains_unchanged(): void
    {
        $firstSheet = $this->parseWorkbookRow($this->row([
            'account_number' => 'ACC-1001',
            'receipt_number' => 'OR-1001',
            'engine_number' => 'ENG-1001',
        ]));

        $secondSheet = $this->parseWorkbookRow($this->row([
            'account_number' => 'ACC-1001',
            'receipt_number' => 'OR-1001',
            'engine_number' => 'ENG-1001',
        ]));

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame(1, (int) $firstSheet->fresh()->imported_rows);
        $this->assertSame(0, (int) $secondSheet->fresh()->imported_rows);
        $this->assertSame(1, (int) $secondSheet->fresh()->duplicate_rows);
        $this->assertSame(0, ImportConflict::count());
    }

    public function test_retrying_same_fallback_row_updates_existing_conflict_without_duplicate_insert(): void
    {
        $this->createOldIncompleteTransaction();

        [$batch, $sheet] = $this->createWorkbookSheet($this->row([
            'account_number' => 'ACC-1001',
        ]));

        app(TransactionSheetParser::class)->parse($batch, $sheet);
        app(TransactionSheetParser::class)->parse($batch->fresh(), $sheet->fresh());

        $sheet->refresh();
        $batch->refresh();

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame(0, (int) $sheet->imported_rows);
        $this->assertSame(1, (int) $sheet->conflict_rows);
        $this->assertSame(0, (int) $sheet->duplicate_rows);
        $this->assertSame(0, (int) $batch->imported_rows);
        $this->assertSame(1, (int) $batch->conflict_rows);
        $this->assertSame(1, ImportConflict::count());
        $this->assertSame('completeness_conflict', ImportConflict::first()->conflict_type);
    }

    public function test_populated_different_account_numbers_do_not_fallback_match(): void
    {
        $this->createOldIncompleteTransaction([
            'account_number' => 'OLD-ACCOUNT',
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'account_number' => 'NEW-ACCOUNT',
        ]));

        $this->assertSame(2, SalesTransaction::count());
        $this->assertSame(1, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(0, ImportConflict::count());
    }

    private function createOldIncompleteTransaction(array $overrides = []): SalesTransaction
    {
        return SalesTransaction::create(array_merge([
            'import_batch_id' => $this->createBatch()->id,
            'import_batch_sheet_id' => null,
            'branch_id' => $this->branch->id,
            'invoice_date' => '2026-06-10',
            'account_number' => null,
            'customer_name' => 'Juan Dela Cruz',
            'transaction_type' => 'Cash Sales',
            'receipt_number' => null,
            'product' => 'Brand New',
            'product_line_name' => 'MOTORCYCLE',
            'brand_name_raw' => 'HONDA',
            'model' => 'CLICK 125',
            'cash_amount' => 100000,
            'amount' => 100000,
            'raw_row_data' => [],
            'source_row_number' => 4,
        ], $overrides));
    }

    private function parseWorkbookRow(array $row): ImportBatchSheet
    {
        [$batch, $sheet] = $this->createWorkbookSheet($row);

        app(TransactionSheetParser::class)->parse($batch, $sheet);

        return $sheet->fresh();
    }

    private function createWorkbookSheet(array $row): array
    {
        $batch = $this->createBatch();
        $sheet = ImportBatchSheet::create([
            'import_batch_id' => $batch->id,
            'branch_id' => $this->branch->id,
            'sheet_name' => 'L4 GSC',
            'sheet_type' => 'transaction',
            'total_rows' => 1,
            'status' => 'pending',
        ]);

        $this->writeWorkbook($batch->stored_filename, $sheet->sheet_name, $row);

        return [$batch, $sheet];
    }

    private function createBatch(): ImportBatch
    {
        return ImportBatch::create([
            'uploaded_by' => $this->user->id,
            'original_filename' => 'test.xlsx',
            'stored_filename' => 'imports/test-' . uniqid('', true) . '.xlsx',
            'source_type' => 'manual_upload',
            'status' => 'processed',
        ]);
    }

    private function writeWorkbook(string $path, string $sheetName, array $row): void
    {
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->setTitle($sheetName);

        $worksheet->fromArray($row, null, 'A4');

        $fullPath = Storage::disk('local')->path($path);
        $directory = dirname($fullPath);

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        (new Xlsx($spreadsheet))->save($fullPath);
        $spreadsheet->disconnectWorksheets();
    }

    private function row(array $overrides = []): array
    {
        $data = array_merge([
            'invoice_date' => '2026-06-10',
            'account_number' => null,
            'customer_name' => 'Juan Dela Cruz',
            'contact_number' => null,
            'birth_date' => null,
            'address' => null,
            'city_municipality' => null,
            'sales_type' => null,
            'agent_referral_name' => null,
            'transaction_type' => 'Cash Sales',
            'receipt_number' => null,
            'sales_source' => null,
            'product' => 'Brand New',
            'product_line_name' => 'MOTORCYCLE',
            'category_name' => null,
            'brand_name' => 'HONDA',
            'model' => 'CLICK 125',
            'capacity' => null,
            'product_description' => null,
            'serial_number' => null,
            'engine_number' => null,
            'chassis_number' => null,
            'parts_number' => null,
            'color' => null,
            'stock_code' => null,
            'product_remarks' => null,
            'amount' => 100000,
            'cash_amount' => 100000,
            'downpayment_amount' => null,
            'promissory_note_amount' => null,
            'gross_sales_amount' => null,
            'commission_amount' => null,
            'monthly_amortization' => null,
            'terms' => null,
            'branch_name_from_sheet' => null,
            'pouching_date' => null,
            'encoded_by' => null,
            'date_last_updated' => null,
        ], $overrides);

        return [
            $data['invoice_date'],
            $data['account_number'],
            $data['customer_name'],
            $data['contact_number'],
            $data['birth_date'],
            $data['address'],
            $data['city_municipality'],
            $data['sales_type'],
            $data['agent_referral_name'],
            $data['transaction_type'],
            $data['receipt_number'],
            $data['sales_source'],
            $data['product'],
            $data['product_line_name'],
            $data['category_name'],
            $data['brand_name'],
            $data['model'],
            $data['capacity'],
            $data['product_description'],
            $data['serial_number'],
            $data['engine_number'],
            $data['chassis_number'],
            $data['parts_number'],
            $data['color'],
            $data['stock_code'],
            $data['product_remarks'],
            $data['amount'],
            $data['cash_amount'],
            $data['downpayment_amount'],
            $data['promissory_note_amount'],
            $data['gross_sales_amount'],
            $data['commission_amount'],
            $data['monthly_amortization'],
            $data['terms'],
            $data['branch_name_from_sheet'],
            $data['pouching_date'],
            $data['encoded_by'],
            $data['date_last_updated'],
        ];
    }
}
