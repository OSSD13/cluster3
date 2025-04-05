<?php
<<<<<<< HEAD
/*
* Department
* Manage department
* @author : Natthanan Sirisurayut 66160352
* @Create Date : 2025-03-30
*/
=======

>>>>>>> 83966c2 (feat:(.blade.php): เขียนฟังก์ชันให้สมบูรณ์)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;
    protected $table = 'wrs_departments'; // Specify the table name
    protected $primaryKey = 'dept_id';
    public $timestamps = false;
=======

/**
 * Department Model
 *
 * @package App\Models
 */
class Department extends Model
{
    use HasFactory;

    protected $table = 'wrs_departments';

    protected $primaryKey = 'dept_id';

>>>>>>> 83966c2 (feat:(.blade.php): เขียนฟังก์ชันให้สมบูรณ์)
    protected $fillable = [
        'dept_name',
        'dept_created_date',
        'dept_update_date',
    ];
<<<<<<< HEAD
    public function employees(): HasMany
=======

    public $timestamps = false;  // เพราะใช้ timestamp ใน Migration แล้ว

    /**
     * Get the employees for the department.
     */
    public function employees()
>>>>>>> 83966c2 (feat:(.blade.php): เขียนฟังก์ชันให้สมบูรณ์)
    {
        return $this->hasMany(Employee::class, 'emp_dept_id', 'dept_id');
    }
}
