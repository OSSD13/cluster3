<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Task;
use App\Models\WorkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WorkRequestController extends Controller
{
    // public function showDetail()
    // {
    //     $emp = Employee::all();
    //     $workRequest = WorkRequest::all();
    //     $task = Task::all();
    //     $dept = Department::all();
    //     return view('home_show_detail', compact('emp', 'workRequest', 'task', 'dept'));
    // }

    // public function archive()
    // {
    //     // ดึงข้อมูลงานที่เสร็จแล้วและถูกปฏิเสธ
    //     $completedRequests = WorkRequest::where('req_status', 'Completed')->get();
    //     $rejectedRequests = WorkRequest::where('req_status', 'Rejected')->get();
    //     $completedTasks = Task::where('tsk_status', 'Completed')->get();
    //     $rejectedTasks = Task::where('tsk_status', 'Rejected')->get();
    //     $tasks = Task::with('workRequest.tasks')->get();
    //     $workRequests = WorkRequest::with(['employee', 'department', 'tasks'])->get();
    //     // ส่งข้อมูลไปยัง view
    //     return view('archive_table', compact('completedRequests', 'rejectedRequests','completedTasks', 'rejectedTasks','tasks','workRequests'));
    // }

    // public function sent()
    // {
    //     return view('sent');
    // }
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ที่ล็อกอินจาก Session
        $currentUser = Session::get('user');

        // จัดกลุ่มข้อมูลในตัวแปร $tasks โดยกรองเฉพาะของผู้ใช้ที่ล็อกอิน
        $tasks = [
            'received' => [
                'my' => Task::where('tsk_status', 'Pending')
                            ->where('tsk_assignee_type', 'ind')
                            ->where('tsk_emp_id', $currentUser->emp_id) // กรองตาม ID ผู้ใช้
                            ->get(),
                'dept' => Task::where('tsk_status', 'Pending')
                              ->where('tsk_assignee_type', 'dept')
                              ->where('tsk_dept_id', $currentUser->emp_dept_id) // กรองตามแผนก
                              ->get(),
            ],
            'inprogress' => [
                'my' => Task::where('tsk_status', 'In Progress')
                            ->where('tsk_assignee_type', 'ind')
                            ->where('tsk_emp_id', $currentUser->emp_id)
                            ->get(),
                'dept' => Task::where('tsk_status', 'In Progress')
                              ->where('tsk_assignee_type', 'dept')
                              ->where('tsk_dept_id', $currentUser->emp_dept_id)
                              ->get(),
            ],
            'completed' => [
                'my' => Task::where('tsk_status', 'Completed')
                            ->where('tsk_assignee_type', 'ind')
                            ->where('tsk_emp_id', $currentUser->emp_id)
                            ->get(),
                'dept' => Task::where('tsk_status', 'Completed')
                              ->where('tsk_assignee_type', 'dept')
                              ->where('tsk_dept_id', $currentUser->emp_dept_id)
                              ->get(),
            ],
        ];

        // ดึงข้อมูลผู้มอบหมายจาก wrs_work_requests
        $workRequests = WorkRequest::all()->keyBy('req_id');
        $employees = Employee::all()->keyBy('req_emp_id');
        $departments = Employee::all()->keyBy('req_dept_id');

        $taskEmp = Task::with(['workRequest.employee'])->get();
        $taskDept = Task::with(['workRequest.department'])->get();




        // ส่งข้อมูลไปยัง view
        return view('home_table', [
            'tasks' => $tasks,
            'workRequests' => $workRequests,
            'employees' => $employees,
            'departments' => $departments,
            'taskEmp' => $taskEmp
        ]);
    }
}