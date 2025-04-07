<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use Illuminate\Http\Request;

class WorkRequestController extends Controller
{
    public function index()
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
        return view('archive_detail', compact('reqName', 'reqDescription', 'tasks', 'reqEmployeeName'));
    }
}
