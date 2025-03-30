<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department; // Import the Department model

class DepartmentController extends Controller
{
    public function index()
    {
        return view('admin.manage_department');
    }
    public function showDepartments()
    {
        // Fetch all departments from the wrs_departments table
        $departments = Department::all();
        return view('admin.manage_department', compact('departments'));
    }

    public function createDepartment(Request $request)
    {
        try {
            $department = new Department();
            $department->dept_name = $request->input('dept_name');
            $department->dept_created_date = now();
            $department->dept_update_date = now();
            $department->save();

            return redirect()->back()->with('success', 'บันทึกข้อมูลแผนกเรียบร้อย!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    public function updateDepartment(Request $request, $id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->dept_name = $request->input('dept_name');
            $department->dept_update_date = now();
            $department->save();

            return redirect()->back()->with('success', 'แก้ไขข้อมูลแผนกเรียบร้อย!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
}
