<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Task;
use App\Models\WorkRequest;
use Illuminate\Http\Request;

class WorkRequestController extends Controller
{
    public function showDetail()
    {
        $emp = Employee::all();
        $workRequest = WorkRequest::all();
        $task = Task::all();
        $dept = Department::all();
        return view('home_show_detail', compact('emp', 'workRequest', 'task', 'dept'));
    }

    public function archive()
    {
        // ดึงข้อมูลงานที่เสร็จแล้วและถูกปฏิเสธ
        $completedRequests = WorkRequest::where('req_status', 'Completed')->get();
        $rejectedRequests = WorkRequest::where('req_status', 'Rejected')->get();
        $completedTasks = Task::where('tsk_status', 'Completed')->get();
        $rejectedTasks = Task::where('tsk_status', 'Rejected')->get();
        $tasks = Task::with('workRequest.tasks')->get();
        $workRequests = WorkRequest::with(['employee', 'department', 'tasks'])->get();
        // ส่งข้อมูลไปยัง view
        return view('archive_table', compact('completedRequests', 'rejectedRequests','completedTasks', 'rejectedTasks','tasks','workRequests'));
    }

    public function sent()
    {
        return view('sent');
    }
}
