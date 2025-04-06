<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('wrs_tasks', function (Blueprint $table) {
        $table->increments('tsk_id'); // เปลี่ยนจาก id() เป็น increments()
        $table->unsignedInteger('tsk_req_id'); // เปลี่ยนจาก unsignedBigInteger() เป็น unsignedInteger()
        $table->foreign('tsk_req_id')->references('req_id')->on('wrs_work_requests')->onDelete('cascade')->onUpdate('cascade');
        $table->enum('tsk_assignee_type', ['ind', 'dept']);
        $table->unsignedInteger('tsk_emp_id'); // เปลี่ยนจาก unsignedBigInteger() เป็น unsignedInteger()
        $table->unsignedInteger('tsk_dept_id'); // เปลี่ยนจาก unsignedBigInteger() เป็น unsignedInteger()
        $table->enum('tsk_status', ['Pending', 'In Progress', 'Completed', 'Rejected']);
        $table->string('tsk_name', 50);
        $table->string('tsk_description', 1000);
        $table->timestamp('tsk_due_date');
        $table->enum('tsk_priority', ['H', 'M', 'L']);
        $table->timestamp('tsk_update_date')->nullable();
        $table->timestamp('tsk_completed_date')->nullable();
        $table->string('tsk_comment_reject', 100)->nullable();
        $table->string('tsk_comment', 500)->nullable();
        $table->foreign('tsk_emp_id')->references('emp_id')->on('wrs_employees');
        $table->foreign('tsk_dept_id')->references('dept_id')->on('wrs_departments');
        
    });
}


    public function down(): void
    {
        Schema::dropIfExists('wrs_tasks');
    }
};

