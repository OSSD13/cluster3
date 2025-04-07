<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkRequest; // Import the WorkRequest model
use Illuminate\Support\Facades\DB; // Import DB facade
use App\Models\Task; // Import Task model

class ReportController extends Controller
{
    public function showReportStat(){
        $workRequests = WorkRequest::with(['employee', 'department'])->get();
        return view('report.report_statistic', compact('workRequests'));
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


    public function getTaskStatistics()
    {
        $user = session('user'); // ดึงข้อมูลผู้ใช้จาก session

        $userId = $user->id;

        // ใช้ Task Model แทน DB::table()
        $taskStatistics = Task::select('tsk_status', DB::raw('COUNT(*) as count'))
        ->where('tsk_emp_id', $userId)
        ->groupBy('tsk_status')
        ->get();

        // แปลงข้อมูลให้อยู่ในรูปแบบที่ง่ายต่อการใช้งานใน View
        $statistics = [
            'total' => $taskStatistics->sum('count'),
            'completed' => $taskStatistics->where('tsk_status', 'Completed')->first()->count ?? 0,
            'delayed' => $taskStatistics->where('tsk_status', 'delayed')->first()->count ?? 0,
            'rejected' => $taskStatistics->where('tsk_status', 'Rejected')->first()->count ?? 0,
        ];

        return view('report.report_statistic', compact('statistics'));
    }
}
