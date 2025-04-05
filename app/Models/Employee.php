<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD
=======
/**
 * Employee Model
 *
 * @package App\Models
 */
>>>>>>> 83966c2 (feat:(.blade.php): เขียนฟังก์ชันให้สมบูรณ์)
class Employee extends Model
{
    use HasFactory;

    protected $table = 'wrs_employees';
<<<<<<< HEAD
    protected $primaryKey = 'emp_id';
    public $timestamps = false;
=======

    protected $primaryKey = 'emp_id';
>>>>>>> 83966c2 (feat:(.blade.php): เขียนฟังก์ชันให้สมบูรณ์)

    protected $fillable = [
        'emp_dept_id',
        'emp_username',
        'emp_password',
        'emp_name',
        'emp_role',
        'emp_created_date',
        'emp_update_date',
    ];
<<<<<<< HEAD
=======

    public $timestamps = false;  // เพราะใช้ timestamp ใน Migration แล้ว

    /**
     * Get the department that owns the employee.
     */
>>>>>>> 83966c2 (feat:(.blade.php): เขียนฟังก์ชันให้สมบูรณ์)
    public function department()
    {
        return $this->belongsTo(Department::class, 'emp_dept_id', 'dept_id');
    }
<<<<<<< HEAD
=======

    /**
     * Get the work requests for the employee.
     */
    public function workRequests()
    {
        return $this->hasMany(WorkRequest::class, 'req_emp_id', 'emp_id');
    }
>>>>>>> 83966c2 (feat:(.blade.php): เขียนฟังก์ชันให้สมบูรณ์)
}
