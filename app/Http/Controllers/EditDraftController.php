<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // เพิ่มเพื่อใช้ transaction
use Illuminate\Support\Facades\Auth;
use App\Models\WorkRequest;
use App\Models\Task;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

/*
 * Class : EditDraftController
 * @author : Salsabeela Sa-e 66160349
 * @Create Date : 2025-04-05
 * ควบคุมการทำงานที่เกี่ยวข้องกับการแก้ไขและอัปเดตใบสั่งงานแบบร่างในส่วนของรายละเอียด
 */
class EditDraftController extends Controller
{

    /*
     * edit()
     * แสดงฟอร์มสำหรับแก้ไขใบสั่งงานแบบร่าง
     * @input : $id (ID ของใบสั่งงานที่ต้องการแก้ไข)
     * @output : view draft_details พร้อมข้อมูลแบบร่างใบสั่งงานและแผนกที่เกี่ยวข้อง
     * @author : Salsabeela Sa-e 66160349
     * @Create Date : 2025-04-05
     */
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


    /*
     * update()
     * อัปเดตข้อมูลใบสั่งงานและงานย่อย
     * @input : Request $request (ข้อมูลที่รับมาจากฟอร์ม)
     * @input : $id (ID ของใบสั่งงานที่ต้องการอัปเดต)
     * @output : redirect กลับไปยังหน้า draft_list พร้อมข้อความสำเร็จ
     * @author : Salsabeela Sa-e 66160349
     * @Create Date : 2025-04-07
     */
    public function update(Request $request, $id)
    {
        // ตรวจสอบข้อมูลฟอร์ม
        $request->validate([
            'task_name' => 'required|string|max:255',
            'creator_status' => 'required|in:ind,dept',
            'task_description' => 'required|string',
            'submit_type' => 'required|in:draft,create',
        ]);

        DB::beginTransaction(); // เริ่ม transaction

        try {
            // หาใบสั่งงาน
            $draft = WorkRequest::findOrFail($id);

            // อัปเดตข้อมูลหลัก
            $draft->req_name = $request->task_name;
            $draft->req_create_type = $request->creator_status;
            $draft->req_description = $request->task_description;
            $draft->req_draft_status = $request->submit_type === 'draft' ? 'D' : 'S';
            $draft->save();

            // ลบงานย่อยเดิมทั้งหมดก่อน
            $draft->tasks()->delete();

            // เพิ่มงานย่อยใหม่
            if ($request->has('subtask_name')) {
                foreach ($request->subtask_name as $index => $subtaskName) {
                    $empId = $request->emp[$index] ?? null;
                    $assigneeType = ($empId !== null && $empId !== "0") ? 'ind' : 'dept';

                    Task::create([
                        'tsk_req_id' => $draft->req_id,
                        'tsk_assignee_type' => $assigneeType,
                        'tsk_emp_id' => (is_numeric($empId) && (int) $empId !== 0) ? (int) $empId : null,
                        'tsk_dept_id' => $request->dept[$index],
                        'tsk_status' => 'Pending',
                        'tsk_name' => $subtaskName,
                        'tsk_description' => $request->description[$index] ?? null,
                        'tsk_due_date' => $request->end_date[$index],
                        'tsk_priority' => $request->priority[$index],
                        'tsk_update_date' => now(),
                    ]);
                }
            }

            DB::commit(); // บันทึกการเปลี่ยนแปลงทั้งหมด

            return redirect()->route('draft_list')->with('success', 'อัปเดตใบสั่งงานเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollback(); // ยกเลิกหากเกิด error
            dd($e);
            return redirect()->back()->withErrors(['error' => 'เกิดข้อผิดพลาดในการอัปเดต: ' . $e->getMessage()]);
        }
    }

}
