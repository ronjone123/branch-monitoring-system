<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\BusinessUnit;
use App\Models\ImportBatch;
use App\Models\Location;
use App\Models\Role;
use App\Models\SalesTransaction;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SalesTransactionExportAuthorizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->prepareDatabase();
    }

    public function test_viewer_cannot_see_sales_transactions_export_button(): void
    {
        $this->actingAs($this->userWithRole('viewer'));

        $this->get(route('sales-transactions.index'))
            ->assertOk()
            ->assertDontSee('href="' . route('sales-transactions.export') . '"', false)
            ->assertSee('Export is only available for Super Admin and Admin.');
    }

    public function test_viewer_cannot_access_sales_transactions_export_route_directly(): void
    {
        $this->actingAs($this->userWithRole('viewer'));

        $this->get(route('sales-transactions.export'))
            ->assertForbidden();
    }

    public function test_admin_can_see_and_access_sales_transactions_export(): void
    {
        $this->actingAs($this->userWithRole('admin'));

        $this->get(route('sales-transactions.index'))
            ->assertOk()
            ->assertSee('href="' . route('sales-transactions.export') . '"', false);

        $this->get(route('sales-transactions.export'))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_export_contains_expected_headers_and_transaction_data(): void
    {
        $this->actingAs($this->userWithRole('admin'));

        $response = $this->get(route('sales-transactions.export'));

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $csv = $response->streamedContent();

        $this->assertStringContainsString('"Invoice Date","Account Number","Customer Name"', $csv);
        $this->assertStringContainsString('Test Customer', $csv);
        $this->assertStringContainsString('HONDA', $csv);
        $this->assertStringContainsString('"CLICK 125"', $csv);
        $this->assertStringContainsString('"Lucky 4 Gensan"', $csv);
        $this->assertStringContainsString('"L4 GSC"', $csv);
    }

    public function test_export_respects_existing_filters(): void
    {
        $this->actingAs($this->userWithRole('admin'));

        $response = $this->get(route('sales-transactions.export', [
            'product_group' => 'appliance',
        ]));

        $response->assertOk();

        $csv = $response->streamedContent();

        $this->assertStringContainsString('Appliance Customer', $csv);
        $this->assertStringContainsString('SAMSUNG', $csv);
        $this->assertStringNotContainsString('Test Customer', $csv);
        $this->assertStringNotContainsString('HONDA', $csv);
    }

    public function test_super_admin_can_see_and_access_sales_transactions_export(): void
    {
        $this->actingAs($this->userWithRole('super_admin'));

        $this->get(route('sales-transactions.index'))
            ->assertOk()
            ->assertSee('href="' . route('sales-transactions.export') . '"', false);

        $this->get(route('sales-transactions.export'))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function test_importer_cannot_see_or_access_sales_transactions_export(): void
    {
        $this->actingAs($this->userWithRole('importer'));

        $this->get(route('sales-transactions.index'))
            ->assertOk()
            ->assertDontSee('href="' . route('sales-transactions.export') . '"', false)
            ->assertSee('Export is only available for Super Admin and Admin.');

        $this->get(route('sales-transactions.export'))
            ->assertForbidden();
    }

    private function prepareDatabase(): void
    {
        Schema::dropIfExists('sales_transactions');
        Schema::dropIfExists('import_batch_sheets');
        Schema::dropIfExists('import_batches');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('business_units');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('status')->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

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
            $table->string('status')->default('uploaded');
            $table->timestamp('imported_at')->nullable();
            $table->timestamps();
        });

        Schema::create('import_batch_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_batch_id');
            $table->foreignId('branch_id')->nullable();
            $table->string('sheet_name');
            $table->string('sheet_type')->default('transaction');
            $table->string('status')->default('imported');
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
            $table->string('street_address')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('sales_type')->nullable();
            $table->string('agent_referral_name')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('sales_source')->nullable();
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
            $table->decimal('srp_cod_amount', 15, 2)->nullable();
            $table->decimal('cash_amount', 15, 2)->nullable();
            $table->decimal('downpayment_amount', 15, 2)->nullable();
            $table->decimal('promissory_note_amount', 15, 2)->nullable();
            $table->decimal('gross_sales_amount', 15, 2)->nullable();
            $table->decimal('commission_amount', 15, 2)->nullable();
            $table->decimal('monthly_amortization', 15, 2)->nullable();
            $table->string('terms')->nullable();
            $table->unsignedInteger('source_row_number')->nullable();
            $table->string('encoded_by')->nullable();
            $table->date('date_last_updated')->nullable();
            $table->timestamps();
        });

        foreach ([
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'importer' => 'Importer',
            'viewer' => 'Viewer',
        ] as $code => $name) {
            Role::create([
                'code' => $code,
                'name' => $name,
            ]);
        }

        $businessUnit = BusinessUnit::create([
            'code' => 'L4',
            'name' => 'Lucky 4',
        ]);

        $location = Location::create([
            'code' => 'GSC',
            'name' => 'Gensan',
        ]);

        $branch = Branch::create([
            'business_unit_id' => $businessUnit->id,
            'location_id' => $location->id,
            'code' => 'L4GSC',
            'display_name' => 'Lucky 4 Gensan',
            'spreadsheet_sheet_name' => 'L4 GSC',
        ]);

        $uploader = $this->userWithRole('admin');

        $batch = ImportBatch::create([
            'uploaded_by' => $uploader->id,
            'original_filename' => 'sales.xlsx',
            'source_type' => 'manual_upload',
            'status' => 'imported',
            'imported_at' => now(),
        ]);

        $sheet = $batch->sheets()->create([
            'branch_id' => $branch->id,
            'sheet_name' => 'L4 GSC',
            'sheet_type' => 'transaction',
            'status' => 'imported',
        ]);

        SalesTransaction::create([
            'import_batch_id' => $batch->id,
            'import_batch_sheet_id' => $sheet->id,
            'branch_id' => $branch->id,
            'invoice_date' => '2026-06-01',
            'account_number' => 'ACC-001',
            'customer_name' => 'Test Customer',
            'contact_number' => '09170000001',
            'transaction_type' => 'Cash Sales',
            'receipt_number' => 'OR-1',
            'unit_type' => 'Brand New',
            'product_line_name' => 'MOTORCYCLE',
            'brand_name_raw' => 'HONDA',
            'model' => 'CLICK 125',
            'cash_amount' => 100000,
            'srp_cod_amount' => 100000,
            'source_row_number' => 4,
            'encoded_by' => 'Encoder One',
            'date_last_updated' => '2026-06-02',
        ]);

        SalesTransaction::create([
            'import_batch_id' => $batch->id,
            'import_batch_sheet_id' => $sheet->id,
            'branch_id' => $branch->id,
            'invoice_date' => '2026-06-03',
            'account_number' => 'ACC-002',
            'customer_name' => 'Appliance Customer',
            'contact_number' => '09170000002',
            'transaction_type' => 'Installment Sales',
            'receipt_number' => 'OR-2',
            'unit_type' => 'Brand New',
            'product_line_name' => 'APPLIANCE',
            'brand_name_raw' => 'SAMSUNG',
            'model' => 'TV 55',
            'promissory_note_amount' => 25000,
            'srp_cod_amount' => 25000,
            'source_row_number' => 5,
            'encoded_by' => 'Encoder Two',
            'date_last_updated' => '2026-06-04',
        ]);
    }

    private function userWithRole(string $roleCode): User
    {
        $role = Role::where('code', $roleCode)->firstOrFail();

        return User::firstOrCreate(
            ['email' => "{$roleCode}@example.test"],
            [
                'name' => $role->name,
                'password' => 'password',
                'role_id' => $role->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
