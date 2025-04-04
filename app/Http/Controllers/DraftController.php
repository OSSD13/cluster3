<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function showDrafts()
{
    $empId = auth()->user()->emp_id; // ถ้ามีระบบ auth
    $drafts = DB::table('wrs_work_requests')
        ->where('req_emp_id', $empId)
        ->where('req_draft_status', 'D')
        ->get();

    return view('employee.drafts', compact('drafts'));
}
}
