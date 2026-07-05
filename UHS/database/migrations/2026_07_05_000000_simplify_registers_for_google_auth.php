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
            foreach (['registers_regno_unique', 'registers_staff_id_unique'] as $indexName) {
                try {
                    $table->dropUnique($indexName);
                } catch (Throwable $e) {
                    // Index may not exist in every local database state.
                }
            }

            $columnsToDrop = [];

            foreach (['password', 'regno', 'staff_id', 'reset_code', 'reset_expires_at'] as $column) {
                if (Schema::hasColumn('registers', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registers', function (Blueprint $table) {
            if (!Schema::hasColumn('registers', 'password')) {
                $table->string('password')->nullable()->after('role');
            }

            if (!Schema::hasColumn('registers', 'regno')) {
                $table->string('regno')->nullable()->unique()->after('email');
            }

            if (!Schema::hasColumn('registers', 'staff_id')) {
                $table->string('staff_id')->nullable()->unique()->after('regno');
            }

            if (!Schema::hasColumn('registers', 'reset_code')) {
                $table->string('reset_code')->nullable()->after('password');
            }

            if (!Schema::hasColumn('registers', 'reset_expires_at')) {
                $table->timestamp('reset_expires_at')->nullable()->after('reset_code');
            }
        });
    }
};
