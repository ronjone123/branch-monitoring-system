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
        Schema::create('branches', function (Blueprint $table) {
        $table->id();
        $table->foreignId('business_unit_id')->constrained()->cascadeOnDelete();
        $table->foreignId('location_id')->constrained()->cascadeOnDelete();
        $table->string('code')->unique();
        $table->string('display_name');
        $table->string('area_barangay')->nullable();
        $table->string('spreadsheet_sheet_name')->nullable();
        $table->string('status')->default('active');
        $table->date('opened_at')->nullable();
        $table->date('closed_at')->nullable();
        $table->text('remarks')->nullable();
        $table->timestamps();});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
