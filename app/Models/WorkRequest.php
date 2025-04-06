<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * WorkRequest Model
 *
 * @package App\Models
 */
class WorkRequest extends Model
{
    use HasFactory;

    protected $table = 'wrs_work_requests';
    
    protected $primaryKey = 'req_id';

    protected $fillable = [
        'req_create_type',
        'req_emp_id',
        'req_dept_id',
        'req_status',
        'req_name',
        'req_description',
        'req_draft_status',
        'req_created_date',
        'req_update_date',
        'req_completed_date',
        'req_code',
    ];

    public $timestamps = false;

    /**
     * Get the employee that created the work request.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'req_emp_id', 'emp_id');
    }

    /**
     * Get the department associated with the work request.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'req_dept_id', 'dept_id');
    }

    /**
     * Get the tasks for the work request.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'tsk_req_id', 'req_id');
    }
}