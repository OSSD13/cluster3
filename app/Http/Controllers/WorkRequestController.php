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

        $workRequestSubmit = WorkRequest::where('req_draft_status', 'S')
            ->where('req_draft_status', '!=', 'A')
            ->get();

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
        $currentUser = Session::get('user');
        $taskWith = Task::with(['workRequest.employee', 'workRequest.department'])->findOrFail($id);
        $emp = Employee::find($currentUser->emp_id);
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
            $task->tsk_emp_id = $req->tsk_emp_id;
        }
        $task->tsk_emp_id = $req->tsk_emp_id;
        $task->tsk_status = $req->tsk_status;
        $task->tsk_comment = $req->tsk_comment;
        $task->tsk_comment_reject = $req->tsk_comment_reject;
        $task->save();

        return redirect()->route('main-page'); // ใช้ชื่อ Route ที่ถูกต้อง
    }
    public function moreDetail($id)
    {
        // ดึงข้อมูลจากตาราง wrs_tasks พร้อมข้อมูลผู้รับมอบหมาย
        $tasks = Task::with(['employee', 'workRequest', 'department'])
            ->where('tsk_req_id', $id)
            ->get();
        // ส่งข้อมูลไปยัง view
        return view('employee.home_more_detail', compact('tasks'));
    }
    public function archive()
    {
        $currentUser = Session::get('user'); // หรือ Auth::user()

        // Archive ที่ส่งแล้วเท่านั้น (Approved)
        $workRequestArchive = WorkRequest::where('req_draft_status', 'A')
            ->where('req_emp_id', $currentUser->emp_id)
            ->whereIn('req_status', ['Completed', 'Rejected'])
            ->get();


        $completedRequests = $workRequestArchive->where('req_status', 'Completed');
        $rejectedRequests = $workRequestArchive->where('req_status', 'Rejected');

        $completedTasks = Task::where('tsk_status', 'Completed')
            ->where('tsk_emp_id', $currentUser->emp_id)
            ->get();

        $rejectedTasks = Task::where('tsk_status', 'Rejected')
            ->where('tsk_emp_id', $currentUser->emp_id)
            ->get();
        $completedTasks = Task::where('tsk_status', 'Completed')
            ->where('tsk_emp_id', $currentUser->emp_id)
            ->whereHas('workRequest', function ($query) {
                $query->where('req_draft_status', 'A');
            })
            ->get();

        $rejectedTasks = Task::where('tsk_status', 'Rejected')
            ->where('tsk_emp_id', $currentUser->emp_id)
            ->whereHas('workRequest', function ($query) {
                $query->where('req_draft_status', 'A');
            })
            ->get();
        // $tasks = Task::with('workRequest.tasks')->get();

        $workRequests = WorkRequest::all()->keyBy('req_id');

        return view('employee.archive_table', compact(
            'completedRequests',
            'rejectedRequests',
            'completedTasks',
            'rejectedTasks',
            'workRequests'
        ));
    }

    public function archiveDetail($id)
    {
        $req_id = $id; // req_id ไอดีใบงานส่งมาจากหน้ารายการ เปลี่ยนเลขเป็น id ที่ส่งมาจากหน้ารายการได้เลย
        $workRequest = WorkRequest::with(['tasks.employee'])->where('req_id', $req_id)->first();

        // หาใบงานไม่เจอ
        if (!$workRequest) {
            abort(404, 'Work request not found.');
        }

        // Retrieve the work request details and associated tasks
        $reqName = $workRequest->req_name ?? 'ไม่มีชื่อ';
        $reqDescription = $workRequest->req_description ?? 'ไม่มีคำอธิบาย';
        $tasks = $workRequest->tasks; // Retrieve associated tasks with employees
        $reqEmployeeName = $workRequest->employee->emp_name ?? 'ไม่มีข้อมูล'; // Get the employee name

        // ส่งเข้าไปยัง view
        return view('employee.archive_detail', compact('reqName', 'reqDescription', 'tasks', 'reqEmployeeName'));
    }

    public function archiveDetailSelf($id, $empId)
    {
        $req_id = $id; // req_id ไอดีใบงานส่งมาจากหน้ารายการ
        $emp_id = $empId; // emp_id ไอดีพนักงานส่งมาจากหน้ารายการ

        $workRequest = WorkRequest::with(['tasks' => function ($query) use ($emp_id) {
            $query->where('tsk_emp_id', $emp_id);
        }, 'tasks.employee'])->where('req_id', $req_id)->first();

        // หาใบงานไม่เจอ
        if (!$workRequest) {
            abort(404, 'Work request not found.');
        }

        $reqName = $workRequest->req_name ?? 'ไม่มีชื่อ';
        $reqDescription = $workRequest->req_description ?? 'ไม่มีคำอธิบาย';
        $tasks = $workRequest->tasks; // Now contains only tasks for this employee
        $reqEmployeeName = $workRequest->employee->emp_name ?? 'ไม่มีข้อมูล';

        return view('employee.archive_detail_self', compact('reqName', 'reqDescription', 'tasks', 'reqEmployeeName'));
    }

    public function sent()
    {
        return view('employee.sent');
    }
}
