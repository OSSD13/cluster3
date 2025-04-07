<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wrs_work_requests', function (Blueprint $table) {
            $table->increments('req_id'); // เปลี่ยนจาก id() เป็น increments()
            $table->enum('req_create_type', ['ind', 'dept']);
            $table->unsignedInteger('req_emp_id')->nullable(); // เปลี่ยนจาก unsignedBigInteger() เป็น unsignedInteger()
            $table->foreign('req_emp_id')->references('emp_id')->on('wrs_employees')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedInteger('req_dept_id')->nullable(); // เปลี่ยนจาก unsignedBigInteger() เป็น unsignedInteger()
            $table->foreign('req_dept_id')->references('dept_id')->on('wrs_departments')->onDelete('set null')->onUpdate('cascade');
            $table->enum('req_status', ['Pending', 'In Progress', 'Completed', 'Rejected'])->default('Pending');
            $table->string('req_name', 50);
            $table->text('req_description');
            $table->enum('req_draft_status', ['D', 'S']);
            $table->timestamp('req_created_date')->useCurrent();
            $table->timestamp('req_update_date')->nullable()->useCurrentOnUpdate();
            $table->timestamp('req_completed_date')->nullable();
            $table->string('req_code', 10)->unique();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wrs_work_requests');
    }
};
