<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Employee Model
 *
 * @package App\Models
 */
class Employee extends Model
{
    use HasFactory;

    protected $table = 'wrs_employees';
    protected $primaryKey = 'emp_id';
    public $timestamps = false;

    protected $fillable = [
        'emp_dept_id',
        'emp_username',
        'emp_password',
        'emp_name',
        'emp_role',
        'emp_created_date',
        'emp_update_date',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class, 'emp_dept_id', 'dept_id');
    }

    /**
     * Get the work requests for the employee.
     */
    public function workRequests()
    {
        return $this->hasMany(WorkRequest::class, 'req_emp_id', 'emp_id');
    }
}