<?php

/*
* Department
* Manage department
* @author : Natthanan Sirisurayut 66160352
* @Create Date : 2025-03-30
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $fillable = [
        'dept_name',
        'dept_created_date',
        'dept_update_date',
    ];

    public $timestamps = false;  // เพราะใช้ timestamp ใน Migration แล้ว

    /**
     * Get the employees for the department.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'emp_dept_id', 'dept_id');
    }
}
