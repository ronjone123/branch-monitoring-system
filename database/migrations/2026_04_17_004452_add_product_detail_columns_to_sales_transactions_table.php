<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sales_transactions', function (Blueprint $table) {
            $table->string('unit_type')->nullable()->after('product');
            $table->string('product_line_name')->nullable()->after('unit_type');
            $table->string('category_name_raw')->nullable()->after('product_line_name');
            $table->string('brand_name_raw')->nullable()->after('category_name_raw');
            $table->string('model')->nullable()->after('brand_name_raw');
            $table->string('capacity')->nullable()->after('model');
            $table->text('product_description')->nullable()->after('capacity');
            $table->string('serial_number')->nullable()->after('product_description');
            $table->string('engine_number')->nullable()->after('serial_number');
            $table->string('chassis_number')->nullable()->after('engine_number');
            $table->string('parts_number')->nullable()->after('chassis_number');
            $table->string('color')->nullable()->after('parts_number');
            $table->string('stock_code')->nullable()->after('color');
            $table->text('product_remarks')->nullable()->after('stock_code');
        });
    }

    public function down(): void
    {
        Schema::table('sales_transactions', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};