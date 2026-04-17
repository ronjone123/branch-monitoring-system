<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('import_batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('import_batch_sheet_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();

            $table->date('invoice_date')->nullable();
            $table->string('account_number')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();

            $table->string('sales_type')->nullable();
            $table->string('agent_referral_name')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('receipt_number')->nullable();
            $table->string('sales_source')->nullable();
            $table->string('product')->nullable();

            $table->decimal('amount', 15, 2)->nullable();
            $table->string('terms')->nullable();
            $table->string('branch_name_from_sheet')->nullable();
            $table->date('pouching_date')->nullable();
            $table->string('encoded_by')->nullable();
            $table->date('date_last_updated')->nullable();

            $table->unsignedInteger('source_row_number')->nullable();
            $table->json('raw_row_data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_transactions');
    }
};
