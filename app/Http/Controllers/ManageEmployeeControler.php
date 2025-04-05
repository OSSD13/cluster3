<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
class ManageEmployeeControler extends Controller
{
     /*
    * showEmployee()
    * Show the manage Employee page
    * @input : -
    * @output : manage department page
    * @author : Naphat Maneechansuk 66160099
    * @Create Date : 2025-04-04
    */
    public function showEmployee()
    {
        // Fetch all departments from the wrs_departments table
        $employees = Employee::all();
        $departments = Department::all();
        return view('admin.manage_employee', compact('employees', 'departments'));
    }

    /*
    * editEmployee(Request $request, $id)
    * Edit employee department
    * @input : emp_dept_id
    * @output : employee after edit to manage employee page
    * @author : Naphat Maneechansuk 66160099
    * @Create Date : 2025-04-04
    */
    public function editEmployee(Request $request, $id)
    {
        try {
            $employees = Employee::findOrFail($id);
            $employees->emp_dept_id = $request->input('emp_dept_id');
            $employees->emp_update_date = now();
            $employees->save();

            return redirect()->back()->with('success', 'แก้ไขข้อมูลแผนกเรียบร้อย!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
    /*
    * searchEmployee(Request $req)
    * Search employee by name
    * @input : emp_name
    * @output : employee list to manage employee page
    * @author : Naphat Maneechansuk 66160099
    * @Create Date : 2025-04-05
    */
    public function searchEmployee(Request $req){
        $output = "";
        $employees = Employee::where('emp_name', 'LIKE', '%' . $req->search . '%')->get();
        foreach($employees as $employee){
            $output .=
            '<tr>
                <th scope="row " class="text-center">' . str_pad($employee->emp_id, 4, '0' , STR_PAD_LEFT) . '</th>
                <td class="text-center">'. $employee->emp_name . '</td>
                <td></td>
                <td class="text-center">' . $employee->department->dept_name . '</td>
                <td class="text-center"><i class="bi bi-pencil action-icon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal' . $employee->emp_id .' "></i></td>
            </tr>';
        }

        return response($output);
    }


}
