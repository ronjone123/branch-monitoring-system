<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('import_conflicts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('import_batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('import_batch_sheet_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('existing_sales_transaction_id')->nullable()->constrained('sales_transactions')->nullOnDelete();

            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();

            $table->unsignedInteger('source_row_number')->nullable();

            $table->string('match_key', 64)->index();
            $table->string('new_row_hash', 64)->nullable();

            $table->json('existing_row_data')->nullable();
            $table->json('incoming_row_data')->nullable();

            $table->string('status')->default('pending'); // pending, reviewed, ignored
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_conflicts');
    }
};