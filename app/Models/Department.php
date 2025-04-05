<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments'; // เปลี่ยนให้ตรงกับชื่อตารางจริง
    protected $primaryKey = 'dept_id';
    public $timestamps = false;

    protected $fillable = ['dept_name'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'emp_dept_id', 'dept_id');
    }
}

