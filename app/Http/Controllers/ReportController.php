<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkRequest; // Import the WorkRequest model
use Illuminate\Support\Facades\DB; // Import DB facade
use App\Models\Task; // Import Task model

class ReportController extends Controller
{
    public function showReportStat()
    {
        // ดึงข้อมูลเริ่มต้นสำหรับปีและเดือนปัจจุบัน
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // เรียกใช้ getTaskStatistics เพื่อดึงข้อมูลเริ่มต้น
        $request = new Request(['year' => $currentYear, 'month' => $currentMonth]);
        $statistics = $this->getTaskStatistics($request)->getData();

        // ส่งข้อมูลไปยัง View
        return view('report.report_statistic', compact('statistics'));
    }

    public function showReportTable()
    {
        $workRequests = WorkRequest::with(['employee', 'department', 'tasks.employee', 'tasks.department'])
            ->get();

        // หากต้องการกรองข้อมูล tasks เฉพาะที่ตรงกับ req_id ของแต่ละ WorkRequest
        foreach ($workRequests as $workRequest) {
            $workRequest->tasks = $workRequest->tasks->where('tsk_req_id', $workRequest->req_id);
        }

        return view('report.report_table', compact('workRequests'));
    }


    public function getTaskStatistics(Request $request)
    {
        $user = session('user'); // ดึงข้อมูลผู้ใช้จาก session
        $userId = $user->emp_id; // ใช้ emp_id ของผู้ใช้

        // รับค่าปีและเดือนจาก request
        $year = $request->input('year');
        $month = $request->input('month');

        // ดึงข้อมูลงานของผู้ใช้
        $tasks = Task::where('tsk_emp_id', $userId);

        // กรองข้อมูลตามปีและเดือน
        if ($year) {
            $tasks->whereYear('tsk_due_date', $year);
        }
        if ($month && $month != 'all') {
            $tasks->whereMonth('tsk_due_date', $month);
        }

        $tasks = $tasks->get();

        // แยกประเภทงาน
        $completedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Completed' && $task->tsk_completed_date !== null;
        });

        $delayedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Completed' &&
                   $task->tsk_completed_date !== null &&
                   $task->tsk_completed_date > $task->tsk_due_date; // เปรียบเทียบวันที่
        });

        $rejectedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Rejected';
        });

        // สร้างสถิติ
        $statistics = [
            'total' => $tasks->count(),
            'completed' => $completedTasks->count(),
            'delayed' => $delayedTasks->count(),
            'rejected' => $rejectedTasks->count(),
        ];

        return response()->json($statistics); // ส่งข้อมูลกลับในรูปแบบ JSON
    }
}
