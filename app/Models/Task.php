<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Task Model
 *
 * @package App\Models
 */
class Task extends Model
{
    use HasFactory;

    protected $table = 'wrs_tasks';

    protected $primaryKey = 'tsk_id';

    protected $fillable = [
        'tsk_req_id',
        'tsk_assignee_type',
        'tsk_emp_id',
        'tsk_dept_id',
        'tsk_status',
        'tsk_name',
        'tsk_description',
        'tsk_due_date',
        'tsk_priority',
        'tsk_update_date',
        'tsk_completed_date',
        'tsk_comment_reject',
        'tsk_comment',
    ];

    public $timestamps = false;

    /**
     * Get the work request associated with the task.
     */


    /**
     * Get the employee assigned to the task.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'tsk_emp_id', 'emp_id');
    }

    /**
     * Get the department assigned to the task.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'tsk_dept_id', 'dept_id');
    }
}
