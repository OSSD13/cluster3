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
    public function showDetail($id)
    {
        $taskWith = Task::with(['workRequest.employee', 'workRequest.department'])->findOrFail($id);
        $emp = Employee::all();
        $workRequest = WorkRequest::all();
        $task = Task::all()->where('tsk_id', $id);
        $dept = Department::all();
        return view('employee.home_show_detail', compact('emp', 'workRequest', 'task', 'dept','taskWith'));
    }
    public function updateTask(Request $req)
    {
        // ดึงข้อมูลจาก request
        $task = Task::find($req->tsk_id);
        $task->tsk_status = $req->tsk_status;
        $task->tsk_comment = $req->tsk_comment;
        $task->save();

        // ส่งกลับไปยังหน้าเดิม
        return redirect('/main');
    }

    public function achrive()
    {
        // ดึงข้อมูลงานที่เสร็จแล้วและถูกปฏิเสธ
        $completedRequests = WorkRequest::where('req_status', 'Completed')->get();
        $rejectedRequests = WorkRequest::where('req_status', 'Rejected')->get();
        $completedTasks = Task::where('tsk_status', 'Completed')->get();
        $rejectedTasks = Task::where('tsk_status', 'Rejected')->get();
        $tasks = Task::with('workRequest.tasks')->get();
        $workRequests = WorkRequest::with(['employee', 'department', 'tasks'])->get();
        // ส่งข้อมูลไปยัง view
        return view('employee.achrive_table', compact('completedRequests', 'rejectedRequests','completedTasks', 'rejectedTasks','tasks','workRequests'));
    }

    // public function sent()
    // {
    //     return view('sent');
    // }
    public function index()
    {
        // ดึงข้อมูลผู้ใช้ที่ล็อกอินจาก Session
        $currentUser = Session::get('user');

        // จัดกลุ่มข้อมูลในตัวแปร $tasks โดยกรองเฉพาะของผู้ใช้ที่ล็อกอิน 
        $workRequestSubmit = [
            'submit' => WorkRequest::where('req_draft_status', 'S')
                ->get(), // ดึงข้อมูลที่มีสถานะ 'S' (ส่ง)
        ];
        $task = [
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
        $tasks = [
            'received' => [
                'my' => collect(),
                'dept' => collect(),
            ],
            'inprogress' => [
                'my' => collect(),
                'dept' => collect(),
            ],
            'completed' => [
                'my' => collect(),
                'dept' => collect(),
            ],
        ];
        $allTask = Task::all();
        // เรียง Task ตาม tsk_id ภายใต้ work request เดียวกัน



        foreach ($workRequestSubmit['submit'] as $workRequest) {
            foreach ($task['received']['my'] as $index => $tsk) {
                if ($workRequest->req_id == $tsk->tsk_req_id) {
                    $tasksInReq = $allTask->where('tsk_req_id', $tsk->tsk_req_id)->sortBy('tsk_id')->values();

                    // หาตำแหน่งของ task ปัจจุบัน
                    $index = $tasksInReq->search(function ($item) use ($tsk) {
                        return $item->tsk_id == $tsk->tsk_id;
                    });

                    if ($index === 0) {
                        // ตัวแรก แสดงได้เสมอ
                        $tasks['received']['my']->push($tsk);
                    } else {
                        $previousTask = $tasksInReq[$index - 1];
                        if ($previousTask->tsk_status === 'Completed') {
                            $tasks['received']['my']->push($tsk);
                        }
                    }
                }
            }
            foreach ($task['received']['dept'] as $tsk) {
                if ($workRequest->req_id == $tsk->tsk_req_id) {
                    $tasksInReq = $allTask->where('tsk_req_id', $tsk->tsk_req_id)->sortBy('tsk_id')->values();

                    // หาตำแหน่งของ task ปัจจุบัน
                    $index = $tasksInReq->search(function ($item) use ($tsk) {
                        return $item->tsk_id == $tsk->tsk_id;
                    });

                    if ($index === 0) {
                        // ตัวแรก แสดงได้เสมอ
                        $tasks['received']['dept']->push($tsk);
                    } else {
                        $previousTask = $tasksInReq[$index - 1];
                        if ($previousTask->tsk_status === 'Completed') {
                            $tasks['received']['dept']->push($tsk);
                        }
                    }
                }
            }
            foreach ($task['inprogress']['my'] as $tsk) {
                if ($workRequest->req_id == $tsk->tsk_req_id) {
                    $tasks['inprogress']['my']->push($tsk);
                }
            }
            foreach ($task['inprogress']['dept'] as $tsk) {
                if ($workRequest->req_id == $tsk->tsk_req_id) {
                    $tasks['inprogress']['dept']->push($tsk);
                }
            }
            foreach ($task['completed']['my'] as $tsk) {
                if ($workRequest->req_id == $tsk->tsk_req_id) {
                    $tasks['completed']['my']->push($tsk);
                }
            }
            foreach ($task['completed']['dept'] as $tsk) {
                if ($workRequest->req_id == $tsk->tsk_req_id) {
                    $tasks['completed']['dept']->push($tsk);
                }
            }
        }
        // ดึงข้อมูลผู้มอบหมายจาก wrs_work_requests
        $workRequests = WorkRequest::all()->keyBy('req_id');
        $employees = Employee::all()->keyBy('req_emp_id');
        $departments = Employee::all()->keyBy('req_dept_id');


        // ส่งข้อมูลไปยัง view
        return view('employee.home_table', [
            'tasks' => $tasks,
            'workRequests' => $workRequests,
            'employees' => $employees,
            'departments' => $departments,
            'allTask' => $allTask
        ]);
    }
}
