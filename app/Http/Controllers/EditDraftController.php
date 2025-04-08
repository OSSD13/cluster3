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
        // ดึงข้อมูลจาก session
        $user = Session::get('user');

        // ดึงข้อมูลใบสั่งงานที่ต้องการแก้ไข พร้อมงานย่อย
        $draft = WorkRequest::with('tasks')->findOrFail($id);

        // ดึง emp_id ของผู้ใช้ที่ล็อกอิน
        $empId = $user->emp_id;

        // ดึงข้อมูลแผนก
        $dept = Department::with('employees')->get();

        // ส่งข้อมูลไปยัง view สำหรับการแก้ไข
        return view('draft_details', compact('draft', 'dept'));
    }

    public function update(Request $request, $id)
    {
        $draft = WorkRequest::findOrFail($id);  // ค้นหาข้อมูลแบบร่างที่ต้องการอัปเดต

        // อัปเดตข้อมูลของใบสั่งงาน
        $draft->task_name = $request->input('task_name');
        $draft->task_description = $request->input('task_description');
        $draft->creator_status = $request->input('creator_status');

        // ตรวจสอบค่าจาก submit_type เพื่อกำหนดสถานะ
        $submitType = $request->input('submit_type');

        if ($submitType === 'create') {
            $draft->req_status = 'submitted';  // เปลี่ยนสถานะเป็น "ส่ง" (หรือค่าที่คุณต้องการ)
        } else {
            $draft->req_status = 'draft';  // ถ้ากดบันทึกแบบร่าง ค่าจะเป็น "แบบร่าง"
        }

        $draft->save();  // บันทึกการเปลี่ยนแปลงในใบสั่งงาน

        // อัปเดตข้อมูลงานย่อย (subtasks)
        $subtaskNames = $request->input('subtask_name');
        $deptIds = $request->input('dept');
        $empIds = $request->input('emp');
        $priorities = $request->input('priority');
        $endDates = $request->input('end_date');
        $descriptions = $request->input('description');

        // ลบงานย่อยที่เก่าออก (ถ้ามี) ก่อนที่จะเพิ่มงานใหม่
        Task::where('tsk_req_id', $draft->req_id)->delete();

        foreach ($subtaskNames as $index => $subtaskName) {
            $task = new Task();
            $task->tsk_req_id = $draft->req_id;  // เชื่อมโยงกับใบสั่งงาน
            $task->tsk_name = $subtaskName;
            $task->tsk_dept_id = $deptIds[$index];
            $task->tsk_emp_id = $empIds[$index];
            $task->tsk_priority = $priorities[$index];
            $task->tsk_due_date = $endDates[$index];
            $task->tsk_description = $descriptions[$index];
            $task->save();  // บันทึกงานย่อย
        }

        // แจ้งข้อความสำเร็จ
        $message = $submitType === 'create' ? 'ใบสั่งงานถูกส่งเรียบร้อยแล้ว' : 'แบบร่างถูกอัปเดตเรียบร้อย';
        return redirect()->route('draft.list')->with('success', $message);
    }
}
