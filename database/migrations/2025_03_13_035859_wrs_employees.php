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
        Schema::create('wrs_employees', function (Blueprint $table) {
            $table->id('emp_id');
            $table->string('emp_username', 50)->unique();
            $table->string('emp_password', 255);
            $table->string('emp_name', 100);
            $table->foreignId('emp_dept_id')->nullable()->constrained('wrs_departments', 'dept_id');
            $table->enum('emp_role', ['E', 'A'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wrs_employees');
    }
};
