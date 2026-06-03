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
        Schema::table('registers', function (Blueprint $table) {

            // These columns existed in the original table
            $columnsToDrop = [];

            foreach (['firstname','lastname','dob','phone','username','faculty','department','degree','staff_department'] as $col) {
                if (Schema::hasColumn('registers', $col)) {
                    $columnsToDrop[] = $col;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // Add staff_id if not already present
            if (!Schema::hasColumn('registers', 'staff_id')) {
                $table->string('staff_id')->nullable()->unique()->after('regno');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registers', function (Blueprint $table) {
            // Restore dropped columns
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('faculty')->nullable();
            $table->string('department')->nullable();
            $table->string('degree')->nullable();
            $table->string('staff_department')->nullable();
        });
    }
};
