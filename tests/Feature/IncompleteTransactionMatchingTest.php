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
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
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

    public function test_same_account_and_contact_with_different_full_customer_and_sale_details_imports_as_new_sale(): void
    {
        $this->createOldIncompleteTransaction([
            'invoice_date' => '2026-04-14',
            'account_number' => 'GSC01262',
            'customer_name' => 'SALASPE, RANDY PEREZ',
            'contact_number' => '09619882590',
            'receipt_number' => 'SI-2210',
            'product' => 'Brand New',
            'product_line_name' => 'APPLIANCE',
            'brand_name_raw' => 'SAMSUNG',
            'model' => 'WASHER A',
            'cash_amount' => 18463,
            'amount' => 18463,
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'invoice_date' => '2026-04-15',
            'account_number' => 'GSC01262',
            'customer_name' => 'SALASPE, GERALD PEREZ',
            'contact_number' => '09619882590',
            'receipt_number' => 'DR-0231',
            'product' => 'Repo',
            'product_line_name' => 'APPLIANCE',
            'brand_name' => 'SAMSUNG',
            'model' => 'REF B',
            'cash_amount' => 8531,
            'amount' => 8531,
        ]));

        $this->assertSame(2, SalesTransaction::count());
        $this->assertSame(1, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(0, (int) $sheet->fresh()->conflict_rows);
        $this->assertSame(0, ImportConflict::count());
        $this->assertTrue(SalesTransaction::where('customer_name', 'SALASPE, GERALD PEREZ')->exists());
    }

    public function test_same_account_and_exact_full_customer_name_still_creates_related_account_conflict(): void
    {
        $this->createOldIncompleteTransaction([
            'account_number' => 'ACC-1001',
            'customer_name' => 'Maria Santos',
            'contact_number' => '09170000000',
            'birth_date' => '1990-01-01',
            'address' => 'Purok 1',
            'city_municipality' => 'Gensan',
            'receipt_number' => 'OR-OLD',
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'account_number' => 'ACC-1001',
            'customer_name' => 'Maria Santos',
            'receipt_number' => 'OR-NEW',
        ]));

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame(0, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(1, (int) $sheet->fresh()->conflict_rows);
        $this->assertSame('related_account_conflict', ImportConflict::first()->conflict_type);
    }

    public function test_same_account_and_same_receipt_still_creates_related_account_conflict(): void
    {
        $this->createOldIncompleteTransaction([
            'account_number' => 'ACC-2002',
            'customer_name' => 'First Customer',
            'receipt_number' => 'OR-SAME-2002',
            'engine_number' => 'ENG-OLD-2002',
            'model' => 'CLICK 125',
        ]);

        $sheet = $this->parseWorkbookRow($this->row([
            'account_number' => 'ACC-2002',
            'customer_name' => 'Second Customer',
            'receipt_number' => 'OR-SAME-2002',
            'engine_number' => 'ENG-NEW-2002',
            'model' => 'MIO 125',
            'cash_amount' => 120000,
            'amount' => 120000,
        ]));

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame(0, (int) $sheet->fresh()->imported_rows);
        $this->assertSame(1, (int) $sheet->fresh()->conflict_rows);
        $this->assertSame('related_account_conflict', ImportConflict::first()->conflict_type);
    }

    public function test_related_account_conflict_can_be_imported_as_separate_transaction_once(): void
    {
        $this->withoutMiddleware([
            Authenticate::class,
            EnsureEmailIsVerified::class,
            EnsureUserHasRole::class,
        ]);
        $this->actingAs($this->user);

        $existing = $this->createOldIncompleteTransaction([
            'account_number' => 'GSC01262',
            'customer_name' => 'SALASPE, RANDY PEREZ',
            'contact_number' => '09619882590',
            'receipt_number' => 'SI-2210',
        ]);

        $incomingRow = $this->row([
            'invoice_date' => '2026-04-15',
            'account_number' => 'GSC01262',
            'customer_name' => 'SALASPE, GERALD PEREZ',
            'contact_number' => '09619882590',
            'receipt_number' => 'DR-0231',
            'product' => 'Repo',
            'model' => 'REF B',
            'cash_amount' => 8531,
            'amount' => 8531,
        ]);

        $conflict = $this->createRelatedAccountConflict($existing, $incomingRow);

        $this->post(route('import-conflicts.import-separate', $conflict))
            ->assertRedirect(route('import-conflicts.show', $conflict));

        $this->post(route('import-conflicts.import-separate', $conflict->fresh()))
            ->assertRedirect(route('import-conflicts.show', $conflict));

        $this->assertSame(2, SalesTransaction::count());

        $imported = SalesTransaction::where('customer_name', 'SALASPE, GERALD PEREZ')->first();

        $this->assertNotNull($imported);
        $this->assertSame($conflict->import_batch_id, $imported->import_batch_id);
        $this->assertSame($conflict->import_batch_sheet_id, $imported->import_batch_sheet_id);
        $this->assertSame($this->branch->id, $imported->branch_id);
        $this->assertSame(4, (int) $imported->source_row_number);
        $this->assertNotNull($imported->match_key);
        $this->assertNotNull($imported->row_hash);
        $this->assertSame('resolved', $conflict->fresh()->status);
    }

    public function test_related_account_conflict_shows_both_manual_resolution_choices(): void
    {
        $this->withoutMiddleware([
            Authenticate::class,
            EnsureEmailIsVerified::class,
            EnsureUserHasRole::class,
        ]);
        $this->actingAs($this->user);

        $existing = $this->createOldIncompleteTransaction([
            'account_number' => 'GSC01262',
            'customer_name' => 'SALASPE, RANDY PEREZ',
            'receipt_number' => 'SI-2210',
        ]);

        $conflict = $this->createRelatedAccountConflict($existing, $this->row([
            'account_number' => 'GSC01262',
            'customer_name' => 'SALASPE, RANDY PEREZ',
            'receipt_number' => 'SI-2210',
            'serial_number' => 'SERIAL-CORRECTED',
        ]));

        $this->get(route('import-conflicts.show', $conflict))
            ->assertOk()
            ->assertSee('Apply Newest Data / Accept Incoming Update')
            ->assertSee('Import as Separate Transaction / Confirm as Separate Customer')
            ->assertSee('Use Apply Newest Data when the latest import corrects the existing sale.');
    }

    public function test_related_account_conflict_accept_update_applies_newest_unit_details_without_new_sale(): void
    {
        $this->withoutMiddleware([
            Authenticate::class,
            EnsureEmailIsVerified::class,
            EnsureUserHasRole::class,
        ]);

        $existing = $this->createOldIncompleteTransaction([
            'account_number' => 'GSC01262',
            'customer_name' => 'SALASPE, RANDY PEREZ',
            'receipt_number' => 'SI-2210',
            'serial_number' => 'SERIAL-OLD',
            'engine_number' => 'ENGINE-OLD',
            'chassis_number' => 'CHASSIS-OLD',
            'stock_code' => 'STOCK-OLD',
        ]);

        $conflict = $this->createRelatedAccountConflict($existing, $this->row([
            'account_number' => 'GSC01262',
            'customer_name' => 'SALASPE, RANDY PEREZ',
            'receipt_number' => 'SI-2210',
            'product' => 'Brand New',
            'serial_number' => 'SERIAL-CORRECTED',
            'engine_number' => 'ENGINE-CORRECTED',
            'chassis_number' => 'CHASSIS-CORRECTED',
            'stock_code' => 'STOCK-CORRECTED',
        ]));

        $this->patch(route('import-conflicts.accept-update', $conflict))
            ->assertRedirect(route('import-conflicts.show', $conflict))
            ->assertSessionHas('success');

        $this->patch(route('import-conflicts.accept-update', $conflict->fresh()))
            ->assertRedirect(route('import-conflicts.show', $conflict))
            ->assertSessionHas('warning');

        $updated = $existing->fresh();

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame('SERIAL-CORRECTED', $updated->serial_number);
        $this->assertSame('ENGINE-CORRECTED', $updated->engine_number);
        $this->assertSame('CHASSIS-CORRECTED', $updated->chassis_number);
        $this->assertSame('STOCK-CORRECTED', $updated->stock_code);
        $this->assertSame('resolved', $conflict->fresh()->status);
    }

    public function test_import_as_separate_customer_is_not_available_for_missing_from_latest_import(): void
    {
        $this->withoutMiddleware([
            Authenticate::class,
            EnsureEmailIsVerified::class,
            EnsureUserHasRole::class,
        ]);

        $existing = $this->createOldIncompleteTransaction();
        $conflict = $this->createRelatedAccountConflict($existing, $this->row([
            'customer_name' => 'Separate Customer',
            'receipt_number' => 'DR-0231',
        ]), [
            'conflict_type' => 'missing_from_latest_import',
        ]);

        $this->post(route('import-conflicts.import-separate', $conflict))
            ->assertRedirect(route('import-conflicts.show', $conflict));

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame('pending', $conflict->fresh()->status);
    }

    public function test_accept_update_is_not_available_for_missing_from_latest_import(): void
    {
        $this->withoutMiddleware([
            Authenticate::class,
            EnsureEmailIsVerified::class,
            EnsureUserHasRole::class,
        ]);
        $this->actingAs($this->user);

        $existing = $this->createOldIncompleteTransaction([
            'serial_number' => 'SERIAL-OLD',
        ]);

        $conflict = $this->createRelatedAccountConflict($existing, $this->row([
            'serial_number' => 'SERIAL-CORRECTED',
        ]), [
            'conflict_type' => 'missing_from_latest_import',
        ]);

        $this->get(route('import-conflicts.show', $conflict))
            ->assertOk()
            ->assertDontSee('Apply Newest Data / Accept Incoming Update')
            ->assertDontSee('Import as Separate Transaction / Confirm as Separate Customer');

        $this->patch(route('import-conflicts.accept-update', $conflict))
            ->assertRedirect(route('import-conflicts.show', $conflict))
            ->assertSessionHas('warning');

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame('SERIAL-OLD', $existing->fresh()->serial_number);
        $this->assertSame('pending', $conflict->fresh()->status);
    }

    public function test_import_as_separate_customer_refuses_empty_incoming_row_data(): void
    {
        $this->withoutMiddleware([
            Authenticate::class,
            EnsureEmailIsVerified::class,
            EnsureUserHasRole::class,
        ]);

        $existing = $this->createOldIncompleteTransaction([
            'account_number' => 'ACC-3003',
            'customer_name' => 'Existing Customer',
        ]);

        $conflict = $this->createRelatedAccountConflict($existing, [], [
            'incoming_row_data' => [],
        ]);

        $this->post(route('import-conflicts.import-separate', $conflict))
            ->assertRedirect(route('import-conflicts.show', $conflict))
            ->assertSessionHas('warning');

        $this->assertSame(1, SalesTransaction::count());
        $this->assertSame('Existing Customer', $existing->fresh()->customer_name);
        $this->assertSame('pending', $conflict->fresh()->status);
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

    private function createRelatedAccountConflict(
        SalesTransaction $existing,
        array $incomingRow,
        array $overrides = []
    ): ImportConflict {
        $batch = $this->createBatch();

        $sheet = ImportBatchSheet::create([
            'import_batch_id' => $batch->id,
            'branch_id' => $this->branch->id,
            'sheet_name' => 'L4 GSC',
            'sheet_type' => 'transaction',
            'total_rows' => 1,
            'status' => 'pending',
        ]);

        return ImportConflict::create(array_merge([
            'import_batch_id' => $batch->id,
            'import_batch_sheet_id' => $sheet->id,
            'existing_sales_transaction_id' => $existing->id,
            'branch_id' => $this->branch->id,
            'conflict_type' => 'related_account_conflict',
            'source_row_number' => 4,
            'match_key' => 'held-related-account-conflict',
            'new_row_hash' => null,
            'existing_row_data' => $existing->raw_row_data,
            'incoming_row_data' => $incomingRow,
            'status' => 'pending',
        ], $overrides));
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
