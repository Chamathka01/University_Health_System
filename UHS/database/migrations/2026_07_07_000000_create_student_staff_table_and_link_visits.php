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
        Schema::create('student_staff', function (Blueprint $table) {
            $table->string('nic')->primary();
            $table->string('name');
            $table->string('reg_no')->nullable()->unique();
            $table->string('role');
            $table->date('enrollment_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
        });

        Schema::table('visits', function (Blueprint $table) {
            if (Schema::hasColumn('visits', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable()->change();
            }

            if (! Schema::hasColumn('visits', 'patient_nic')) {
                $table->string('patient_nic')->nullable()->after('patient_id');
                $table->foreign('patient_nic')->references('nic')->on('student_staff')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            if (Schema::hasColumn('visits', 'patient_nic')) {
                $table->dropForeign(['patient_nic']);
                $table->dropColumn('patient_nic');
            }
        });

        Schema::dropIfExists('student_staff');
    }
};
