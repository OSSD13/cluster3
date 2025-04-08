<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function getByDepartment($dept_id)
    {
        $employees = Employee::where('emp_dept_id', $dept_id)->get();

        return response()->json($employees);
    }
}
