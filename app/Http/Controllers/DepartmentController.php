<?php
/*
* Department
* Manage department
* @author : Natthanan Sirisurayut 66160352
* @Create Date : 2025-03-30
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department; // Import the Department model

class DepartmentController extends Controller
{
    /*
    * index()
    * Show the manage department page
    * @input : -
    * @output : manage department page
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-03-30
    */
    public function index()
    {
        return view('admin.manage_department');
    }
    /*
    * showDepartment()
    * Show the manage department page with department list
    * @input : -
    * @output : department name
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-03-30
    */
    public function showDepartments()
    {
        // Fetch all departments from the wrs_departments table
        $departments = Department::all();
        return view('admin.manage_department', compact('departments'));
    }
    /*
    * createDepartment(Request $request)
    * create department
    * @input : department name
    * @output : department name in table
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-03-30
    */
    public function createDepartment(Request $request)
    {
        try {
            $department = new Department();
            $department->dept_name = $request->input('dept_name');
            $department->dept_created_date = now();
            $department->dept_update_date = now();
            $department->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    /*
    * updateDepartment(Request $request, $id)
    * edit department
    * @input : new department name
    * @output : new department name in table
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-03-30
    */
    public function updateDepartment(Request $request, $id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->dept_name = $request->input('dept_name');
            $department->dept_update_date = now();
            $department->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    /*
    * deleteDepartment($id)
    * delete department
    * @input : department id
    * @output : department deleted
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-03-30
    */
    public function deleteDepartment($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with();
        }
    }
    /*
    * searchDepartment(Request $req)
    * search department
    * @input : department name
    * @output : department name in table
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-04-04
    */
    public function searchDepartment(Request $req)
    {
        $output = "";
        $department = Department::where('dept_name', 'LIKE', '%' . $req->search . '%')->get();

        foreach ($department as $dept) {
            $output .=
                '<tr>
                <td class="ps-5">' . $dept->dept_name . '</td>
                <td class="text-end">
                    <i class="bi bi-pencil action-icon" data-bs-toggle="modal" data-bs-target="#editDepartmentModal' . $dept->dept_id . '"></i>
                <i class="bi bi-trash action-icon" data-bs-toggle="modal" data-bs-target="#deleteDepartmentModal' . $dept->dept_id . '"></i>
                </td>
            </tr>';
        }

        return response($output);
    }
}
