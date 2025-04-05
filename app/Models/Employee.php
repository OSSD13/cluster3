<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
