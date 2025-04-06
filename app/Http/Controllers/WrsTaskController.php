<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\WorkRequest;

class WrsTaskController extends Controller
{
    public function index()
    {
        // จัดกลุ่มข้อมูลในตัวแปร $tasks
        $tasks = [
            'received' => [
                'my' => Task::where('tsk_status', 'Pending')->where('tsk_assignee_type', 'ind')->get(),
                'dept' => Task::where('tsk_status', 'Pending')->where('tsk_assignee_type', 'dept')->get(),
            ],
            'inprogress' => [
                'my' => Task::where('tsk_status', 'In Progress')->where('tsk_assignee_type', 'ind')->get(),
                'dept' => Task::where('tsk_status', 'In Progress')->where('tsk_assignee_type', 'dept')->get(),
            ],
            'completed' => [
                'my' => Task::where('tsk_status', 'Completed')->where('tsk_assignee_type', 'ind')->get(),
                'dept' => Task::where('tsk_status', 'Completed')->where('tsk_assignee_type', 'dept')->get(),
            ],
        ];

        // ดึงข้อมูลผู้มอบหมายจาก wrs_work_requests
        $workRequests = WorkRequest::all()->keyBy('req_id');

        // เพิ่มข้อมูลผู้มอบหมายใน $tasks
        foreach ($tasks as $status => $types) {
            foreach ($types as $type => $taskList) {
                foreach ($taskList as $task) {
                    $workRequest = $workRequests->get($task->req_id);
                    $task->assigner_type = $workRequest->req_create_type ?? null;
                }
            }
        }

        // ส่งข้อมูลไปยัง view
        return view('home_table', [
            'tasks' => $tasks,
            'workRequests' => $workRequests, // ส่งตัวแปรนี้ไปยัง View
        ]);
    }
}
