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
        Schema::table('prescription_items', function (Blueprint $table) {
            if (! Schema::hasColumn('prescription_items', 'quantity_per_dose')) {
                $table->integer('quantity_per_dose')->nullable()->after('medicine_id');
            }

            if (! Schema::hasColumn('prescription_items', 'frequency')) {
                $table->string('frequency')->nullable()->after('quantity_per_dose');
            }

            if (! Schema::hasColumn('prescription_items', 'meal_timing')) {
                $table->string('meal_timing')->nullable()->after('frequency');
            }

            if (! Schema::hasColumn('prescription_items', 'duration_days')) {
                $table->integer('duration_days')->nullable()->after('meal_timing');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_items', function (Blueprint $table) {
            foreach (['quantity_per_dose', 'frequency', 'meal_timing', 'duration_days'] as $column) {
                if (Schema::hasColumn('prescription_items', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
