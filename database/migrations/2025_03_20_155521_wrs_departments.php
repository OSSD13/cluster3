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
        Schema::create('wrs_departments', function (Blueprint $table) {
            $table->increments('dept_id'); // ใช้ increments สำหรับ dept_id
            $table->string('dept_name', 50)->unique();
            $table->timestamp('dept_created_date')->useCurrent();
            $table->timestamp('dept_update_date')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wrs_departments');
    }
};
