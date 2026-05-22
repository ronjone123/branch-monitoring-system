<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $indexExists = collect(DB::select("
            SHOW INDEX FROM sales_transactions
            WHERE Key_name = 'sales_transactions_match_key_index'
        "))->isNotEmpty();

        if (! $indexExists) {
            Schema::table('sales_transactions', function (Blueprint $table) {
                $table->index('match_key', 'sales_transactions_match_key_index');
            });
        }
    }

    public function down(): void
    {
        $indexExists = collect(DB::select("
            SHOW INDEX FROM sales_transactions
            WHERE Key_name = 'sales_transactions_match_key_index'
        "))->isNotEmpty();

        if ($indexExists) {
            Schema::table('sales_transactions', function (Blueprint $table) {
                $table->dropIndex('sales_transactions_match_key_index');
            });
        }
    }
};