<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkRequest;
use App\Models\Task;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Session;

class EditDraftController extends Controller
{
    public function index()
    {
        $dept = Department::with('employees')->get();
        return view('draft_details', compact('dept'));
    }

    public function edit($id)
    {
        // ดึงข้อมูลใบสั่งงานที่ต้องการแก้ไข พร้อมงานย่อย
        $draft = WorkRequest::with(['tasks' => function ($query) {
            $query->select(
                'tsk_id',
                'tsk_req_id',
                'tsk_emp_id',
                'tsk_dept_id',
                'tsk_name',
                'tsk_description',
                'tsk_due_date',
                'tsk_priority'
            );
        }])->findOrFail($id);
        // แปลงรูปแบบวันที่ใน tasks
    foreach ($draft->tasks as $task) {
        $task->tsk_due_date = date('Y-m-d', strtotime($task->tsk_due_date));
    }

        // ดึงข้อมูลแผนก
        $dept = Department::with('employees')->get();

        // ส่งข้อมูลไปยัง view สำหรับการแก้ไข
        return view('draft_details', compact('draft', 'dept'));
    }

    public function update(Request $request, $id)
    {
        $draft = WorkRequest::findOrFail($id);

        // อัปเดตข้อมูลใบสั่งงาน
        $draft->req_name = $request->input('task_name');
        $draft->req_description = $request->input('task_description');
        $draft->req_create_type = $request->input('creator_status');
        $draft->req_draft_status = $request->input('submit_type') === 'create' ? 'submitted' : 'draft';
        $draft->save();

        // ลบงานย่อยที่ถูกลบ
        $deletedTasks = explode(',', rtrim($request->input('deleted_tasks'), ','));
        if (!empty($deletedTasks)) {
            Task::whereIn('tsk_id', $deletedTasks)->delete();
        }

        // อัปเดตหรือเพิ่มงานย่อยใหม่
        $subtaskNames = $request->input('subtask_name', []);
        $deptIds = $request->input('dept', []);
        $empIds = $request->input('emp', []);
        $priorities = $request->input('priority', []);
        $endDates = $request->input('end_date', []);
        $descriptions = $request->input('description', []);

        foreach ($subtaskNames as $index => $subtaskName) {
            Task::updateOrCreate(
                ['tsk_req_id' => $draft->req_id, 'tsk_name' => $subtaskName],
                [
                    'tsk_dept_id' => $deptIds[$index] ?? null,
                    'tsk_emp_id' => $empIds[$index] ?? null,
                    'tsk_priority' => $priorities[$index] ?? null,
                    'tsk_due_date' => $endDates[$index] ?? null,
                    'tsk_description' => $descriptions[$index] ?? null,
                ]
            );
        }

        return redirect()->route('draft_list')->with('success', 'แบบร่างถูกอัปเดตเรียบร้อย');
    }
}
