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

    /*
* viewAssignment()
* ฟังก์ชันสำหรับดึงข้อมูลใบงานและงานที่เกี่ยวข้องของผู้ใช้งานปัจจุบัน แยกตามสถานะของงาน (ได้รับ, กำลังดำเนินการ, เสร็จสิ้น)
* พร้อมกรองเฉพาะงานที่สามารถดำเนินการได้ตามลำดับขั้น (หากมีงานก่อนหน้ายังไม่เสร็จจะไม่แสดงงานถัดไป)
* @input : Session::get('user') => ผู้ใช้งานปัจจุบัน
* @output : ส่งข้อมูล tasks, workRequests, employees, departments, allTask ไปยัง view employee.home_table
* @author : Saruta Saisuwan 66160375
* @Create Date : 2025-04-06
*/

    public function viewAssignment()
    {
        $currentUser = Session::get('user');

        $workRequestSubmit = WorkRequest::where('req_draft_status', 'S')
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
    /*
* showDetail($id)
* แสดงรายละเอียดของงานตาม ID ที่ระบุ พร้อมดึงข้อมูลพนักงาน ใบคำขอ และแผนกที่เกี่ยวข้อง
* @input : $id (int) => รหัสงาน (Task ID)
* @output : ส่งข้อมูล emp, workRequest, task, dept, taskWith ไปยัง view employee.home_show_detail
* @author : Saruta Saisuwan 66160375
* @Create Date : 2025-04-06
*/

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
/*
* updateTask(Request $req, $id)
* อัปเดตสถานะและข้อมูลของงานตาม ID ที่ระบุ หากสถานะเป็น Completed จะบันทึกวันที่เสร็จงานด้วย
* @input :
*   - $req (Illuminate\Http\Request) => ข้อมูลที่รับมาจากฟอร์ม เช่น สถานะ ผู้รับผิดชอบ ความเห็น ฯลฯ
*   - $id (int) => รหัสงาน (Task ID)
* @output : redirect กลับไปยัง route 'main-page' หลังจากบันทึกข้อมูลแล้ว
* @author : Saruta Saisuwan 66160375
* @Create Date : 2025-04-06
*/

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
    /*
* moreDetail($id)
* แสดงรายละเอียดของงานทั้งหมดที่เกี่ยวข้องกับใบคำร้อง (Work Request) ที่มี ID ตามที่ระบุ
* @input :
*   - $id (int) => รหัสใบคำร้อง (req_id)
* @output : view 'employee.home_more_detail' ที่แสดงรายการงานทั้งหมดในใบคำร้องนั้น ๆ
* @author : Kidrakon Rattanahiran
* @Create Date : 2025-04-08
*/

    public function moreDetail($id)
    {
        // ดึงข้อมูลจากตาราง wrs_tasks พร้อมข้อมูลผู้รับมอบหมาย
        $tasks = Task::with(['employee', 'workRequest', 'department'])
            ->where('tsk_req_id', $id)
            ->get();
        // ส่งข้อมูลไปยัง view
        return view('employee.home_more_detail', compact('tasks'));
    }
    /*
* archive()
* แสดงรายการใบงานและงานที่เสร็จสิ้นหรือถูกปฏิเสธ (Archive) ของผู้ใช้ปัจจุบัน
* @input : ไม่มี (ดึงข้อมูลจาก Session)
* @output : view 'employee.archive_table' พร้อมข้อมูล:
*   - completedRequests : ใบงานที่สถานะ Completed
*   - rejectedRequests : ใบงานที่สถานะ Rejected
*   - completedTasks : งานที่สถานะ Completed และอยู่ในใบงานที่อนุมัติแล้ว
*   - rejectedTasks : งานที่สถานะ Rejected และอยู่ในใบงานที่อนุมัติแล้ว
*   - workRequests : ข้อมูลใบงานทั้งหมด (ใช้ keyBy เพื่อเข้าถึงง่าย)
* @author : Saruta Saisuwan 66160375
* @Create Date : 2025-04-08
*/

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
 /*
* archiveDetail($id)
* แสดงรายละเอียดของใบงาน (ที่อยู่ในสถานะ Archive) และรายการ Task ที่เกี่ยวข้อง
* @input :
*   - $id : รหัสของใบคำร้องงาน (req_id)
* @output : view 'employee.archive_detail' พร้อมข้อมูล:
*   - reqName : ชื่อใบงาน
*   - reqDescription : คำอธิบายใบงาน
*   - tasks : รายการงานในใบคำร้อง พร้อมข้อมูลผู้รับมอบหมาย
*   - reqEmployeeName : ชื่อพนักงานที่สร้างใบคำร้อง
* @author :  Art-anon Phakhananthanon 66160242
* @Create Date : 2025-04-08
*/

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
/*
* archiveDetailSelf($id, $empId)
* แสดงรายละเอียดใบคำร้อง และรายการ Task เฉพาะของพนักงานที่ระบุ (ใช้สำหรับดูงานที่ตัวเองได้รับมอบหมายใน Archive)
* @input :
*   - $id : รหัสของใบคำร้อง (req_id)
*   - $empId : รหัสของพนักงาน (emp_id)
* @output : view 'employee.archive_detail_self' พร้อมข้อมูล:
*   - reqName : ชื่อใบคำร้อง
*   - reqDescription : คำอธิบายใบคำร้อง
*   - tasks : รายการงานเฉพาะที่พนักงานนี้ได้รับมอบหมาย
*   - reqEmployeeName : ชื่อพนักงานที่สร้างใบคำร้อง
* @author : Art-anon Phakhananthanon 66160242
* @Create Date : 2025-04-08
*/

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
}
