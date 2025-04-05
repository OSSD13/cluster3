<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkRequest; // Import the WorkRequest model



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



}
