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
    public function index()
    {
        $currentUser = Session::get('user');

        $workRequestSubmit = WorkRequest::where('req_draft_status', 'S')->get();

        $task = [
            'received' => [
                'my' => Task::where('tsk_status', 'Pending')
                    ->where('tsk_assignee_type', 'ind')
                    ->where('tsk_emp_id', $currentUser->emp_id)
                    ->get(),

                'dept' => Task::where('tsk_status', 'Pending')
                    ->where('tsk_assignee_type', 'dept')
                    ->where('tsk_dept_id', $currentUser->emp_dept_id)
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

        foreach ($workRequestSubmit as $workRequest) {
            $reqId = $workRequest->req_id;

            // ====== RECEIVED: MY ======
            foreach ($task['received']['my'] as $tsk) {
                if ($tsk->tsk_req_id == $reqId) {
                    $tasksInReq = $allTask->where('tsk_req_id', $reqId)->sortBy('tsk_id')->values();
                    $index = $tasksInReq->search(fn($item) => $item->tsk_id === $tsk->tsk_id);

                    if ($index === 0) {
                        $tasks['received']['my']->push($tsk);
                    } else {
                        $previousTask = $tasksInReq[$index - 1];
                        if ($previousTask->tsk_status === 'Completed') {
                            $tasks['received']['my']->push($tsk);
                        }
                    }
                }
            }

            // ====== RECEIVED: DEPT ======
            foreach ($task['received']['dept'] as $tsk) {
                if ($tsk->tsk_req_id == $reqId) {
                    $tasksInReq = $allTask->where('tsk_req_id', $reqId)->sortBy('tsk_id')->values();
                    $index = $tasksInReq->search(fn($item) => $item->tsk_id === $tsk->tsk_id);

                    if ($index === 0) {
                        $tasks['received']['dept']->push($tsk);
                    } else {
                        $previousTask = $tasksInReq[$index - 1];
                        if ($previousTask->tsk_status === 'Completed') {
                            $tasks['received']['dept']->push($tsk);
                        }
                    }
                }
            }

            // ====== IN PROGRESS & COMPLETED ======
            foreach (['inprogress', 'completed'] as $status) {
                foreach (['my', 'dept'] as $type) {
                    foreach ($task[$status][$type] as $tsk) {
                        if ($tsk->tsk_req_id == $reqId) {
                            $tasks[$status][$type]->push($tsk);
                        }
                    }
                }
            }
        }

        $workRequests = WorkRequest::all()->keyBy('req_id');
        $employees = Employee::all()->keyBy('req_emp_id');
        $departments = Employee::all()->keyBy('req_dept_id');

        return view('employee.home_table', [
            'tasks' => $tasks,
            'workRequests' => $workRequests,
            'employees' => $employees,
            'departments' => $departments,
            'allTask' => $allTask
        ]);
    }
    public function showDetail($id)
    {
        $taskWith = Task::with(['workRequest.employee', 'workRequest.department'])->findOrFail($id);
        $emp = Employee::all();
        $workRequest = WorkRequest::all();
        $task = Task::all()->where('tsk_id', $id);
        $dept = Department::all();
        return view('employee.home_show_detail', compact('emp', 'workRequest', 'task', 'dept', 'taskWith'));
    }

    public function updateTask(Request $req, $id)
    {
        $task = Task::find($id);

        if ($req->tsk_status == 'Completed') {
            $task->tsk_completed_date = now();
        }

        $task->tsk_status = $req->tsk_status;
        $task->tsk_comment = $req->tsk_comment;
        $task->tsk_comment_reject = $req->tsk_comment_reject;
        $task->save();

        return redirect()->route('main-page'); // ใช้ชื่อ Route ที่ถูกต้อง
    }
    public function moreDetail($id)
    {
    // ดึงข้อมูลจากตาราง wrs_tasks พร้อมข้อมูลผู้รับมอบหมาย
$tasks = Task::with(['employee', 'workRequest','department'])
    ->where('tsk_req_id', $id)
    ->get();




    // ส่งข้อมูลไปยัง view
        return view('employee.home_more_detail', compact('tasks'));
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
        return view('employee.achrive_table', compact('completedRequests', 'rejectedRequests', 'completedTasks', 'rejectedTasks', 'tasks', 'workRequests'));
    }

    public function sent()
    {
        return view('employee.sent');
    }
}
