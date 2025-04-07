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
                $table->increments('emp_id'); // emp_id เป็น Primary Key
                $table->unsignedInteger('emp_dept_id'); // emp_dept_id ไม่เป็น nullable
                $table->foreign('emp_dept_id')->references('dept_id')->on('wrs_departments')->onDelete('cascade')->onUpdate('cascade'); // ลบ department เมื่อ employee ถูกลบ
                $table->string('emp_username', 50)->unique();
                $table->string('emp_password', 255);
                $table->string('emp_name', 100);
                $table->enum('emp_role', ['E', 'A']);
                $table->timestamp('emp_created_date')->useCurrent();
                $table->timestamp('emp_update_date')->nullable()->useCurrentOnUpdate();
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
