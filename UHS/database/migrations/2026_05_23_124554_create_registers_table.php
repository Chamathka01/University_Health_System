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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();

            $table->string('firstname');
            $table->string('lastname');
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();

            $table->string('faculty')->nullable();
            $table->string('department')->nullable();
            $table->string('degree')->nullable();
            $table->string('regno')->nullable()->unique();


            $table->string('username')->unique();
            $table->string('role');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
