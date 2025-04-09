<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; // Import the Employee model

class EmployeeController extends Controller
{
    public function getEmployeesByDepartment($deptId)
    {
        // Use the correct column name 'emp_dept_id'
        $employees = Employee::where('emp_dept_id', $deptId)->get(['emp_id', 'emp_name']);
        return response()->json($employees);
    }
}
