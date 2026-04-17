<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_transactions', function (Blueprint $table) {
            $table->decimal('srp_cod_amount', 15, 2)->nullable()->after('amount');
            $table->decimal('cash_amount', 15, 2)->nullable()->after('srp_cod_amount');
            $table->decimal('downpayment_amount', 15, 2)->nullable()->after('cash_amount');
            $table->decimal('promissory_note_amount', 15, 2)->nullable()->after('downpayment_amount');
            $table->decimal('gross_sales_amount', 15, 2)->nullable()->after('promissory_note_amount');
            $table->decimal('commission_amount', 15, 2)->nullable()->after('gross_sales_amount');
            $table->decimal('monthly_amortization', 15, 2)->nullable()->after('commission_amount');
        });
    }

    public function down(): void
    {
        Schema::table('sales_transactions', function (Blueprint $table) {
            $table->dropColumn([
                'srp_cod_amount',
                'cash_amount',
                'downpayment_amount',
                'promissory_note_amount',
                'gross_sales_amount',
                'commission_amount',
                'monthly_amortization',
            ]);
        });
    }
};