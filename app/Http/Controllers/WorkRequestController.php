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
    public function archiveDetail()
    {
        $req_id = 4; // req_id ไอดีใบงานส่งมาจากหน้ารายการ เปลี่ยนเลขเป็น id ที่ส่งมาจากหน้ารายการได้เลย
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

    public function archiveDetailSelf()
    {
        $req_id = 4; // req_id ไอดีใบงานส่งมาจากหน้ารายการ
        $emp_id = 3; // emp_id ไอดีพนักงานส่งมาจากหน้ารายการ

        $workRequest = WorkRequest::with(['tasks' => function($query) use ($emp_id) {
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

    public function archiveTable()
    {
        // ดึงข้อมูลงานที่เสร็จแล้วและถูกปฏิเสธ
        $completedRequests = WorkRequest::where('req_status', 'Completed')->get();
        $rejectedRequests = WorkRequest::where('req_status', 'Rejected')->get();
        $completedTasks = Task::where('tsk_status', 'Completed')->get();
        $rejectedTasks = Task::where('tsk_status', 'Rejected')->get();
        $tasks = Task::with('workRequest.tasks')->get();
        $workRequests = WorkRequest::with(['employee', 'department', 'tasks'])->get();
        // ส่งข้อมูลไปยัง view
        return view('employee.archive_table', compact('completedRequests', 'rejectedRequests','completedTasks', 'rejectedTasks','tasks','workRequests'));
    }
}
