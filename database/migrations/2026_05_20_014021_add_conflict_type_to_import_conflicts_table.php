<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('import_conflicts', function (Blueprint $table) {
            if (! Schema::hasColumn('import_conflicts', 'conflict_type')) {
                $table->string('conflict_type')
                    ->nullable()
                    ->after('branch_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('import_conflicts', function (Blueprint $table) {
            if (Schema::hasColumn('import_conflicts', 'conflict_type')) {
                $table->dropColumn('conflict_type');
            }
        });
    }
};