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
        Schema::table('medical_records', function (Blueprint $table) {
            if (! Schema::hasColumn('medical_records', 'icd10_code')) {
                $table->string('icd10_code')->nullable()->after('diagnosis');
            }

            if (! Schema::hasColumn('medical_records', 'icd10_description')) {
                $table->string('icd10_description')->nullable()->after('icd10_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            foreach (['icd10_code', 'icd10_description'] as $column) {
                if (Schema::hasColumn('medical_records', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
