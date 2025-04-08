<?php
/*
* FormController
* Controller สำหรับจัดการฟอร์มใบสั่งงาน รวมถึงงานย่อยและข้อมูลพนักงานที่เกี่ยวข้อง
* @author : Sarocha Dokyeesun 66160097
* @Create Date : 2025-03-18
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Department, Employee, WorkRequest, Task};
use Illuminate\Support\Facades\{DB, Auth};

class FormController extends Controller
{
    /**
     * index()
     * แสดงหน้าฟอร์มสำหรับสร้างใบสั่งงานใหม่ พร้อมข้อมูลแผนกและพนักงาน
     * @input : -
     * @output : view 'create_form' พร้อมตัวแปร $dept
     * @author : Sarocha Dokyeesun 66160097
     * @Create Date : 2025-03-18
     */
    public function index()
    {
        $dept = Department::with('employees')->get();
        return view('create_form', compact('dept'));
    }

    /**
     * empData($id)
     * ดึงรายชื่อพนักงานในแผนกที่เลือก โดยกรองเฉพาะพนักงานที่มี emp_role = 'E'
     * @input : $id (int) รหัสแผนก
     * @output : JSON response รายชื่อพนักงานในแผนก
     * @author : Sarocha Dokyeesun 66160097
     * @Create Date : 2025-03-18
     */
    public function empData($id)
    {
        $emp = Employee::where('emp_dept_id', $id)
            ->where('emp_role', 'E') // แสดงเฉพาะที่ role = 'E'
            ->get(['emp_id', 'emp_name']); // ดึงเฉพาะฟิลด์ที่จำเป็น
        
        return response()->json($emp);
    }

    /**
     * createWorkRequest(Request $request)
     * บันทึกข้อมูลใบสั่งงาน และงานย่อยลงฐานข้อมูล โดยตรวจสอบ validation และจัดการ transaction
     * @input : Request $request (ข้อมูลจากฟอร์มสร้างใบสั่งงาน)
     * @output : redirect กลับพร้อมข้อความสำเร็จ หรือ error พร้อมย้อนกลับ input เดิม
     * @author : Sarocha Dokyeesun 66160097
     * @Create Date : 2025-03-18
     */
    public function createWorkRequest(Request $request)
    {
        $request->validate([
            'task_name'        => 'required|string|max:255',
            'creator_status'   => 'required|in:ind,dept',
            'subtask_name'     => 'required|array|min:1',
            'subtask_name.*'   => 'required|string|max:255',
            'dept'             => 'required|array',
            'dept.*'           => 'required|integer|min:1',
            'emp'              => 'nullable|array',
            'emp.*'            => 'nullable|integer|min:1',
            'priority'         => 'required|array',
            'priority.*'       => 'required|in:L,M,H',
            'end_date'         => 'required|array',
            'end_date.*'       => 'required|date',
            'task_description' => 'required|string|max:1000',
            'description'      => 'required|array|min:1',
            'description.*'    => 'required|string|max:1000',
        ]);
        DB::beginTransaction();

        try {
            $isDraft = $request->input('submit_type') === 'draft';
            $user = session('user');
            $employeeId = $user->emp_id ?? null;
            $employeeDept = $user->emp_dept_id ?? null;

            if (!$employeeId) {
                return back()->withErrors(['error' => 'Session timeout กรุณา login ใหม่']);
            }

            $yearThai = now()->year + 543; // พ.ศ.
            $shortYear = substr($yearThai, -2); // เอา 2 ตัวท้าย
            $yearRequestsCount = WorkRequest::whereYear('req_created_date', now()->year)->count() + 1;
            $reqCode = 'W' . $shortYear . '-' . str_pad($yearRequestsCount, 4, '0', STR_PAD_LEFT);

            $workRequest = WorkRequest::create([
                'req_create_type'   => $request->input('creator_status'), // ind / dept
                'req_emp_id'        => $employeeId,
                'req_dept_id'       => $request->creator_status === 'dept' ? $employeeDept : null,
                'req_status'        => 'Pending',
                'req_name'          => $request->input('task_name'),
                'req_description'   => $request->input('task_description'),
                'req_draft_status'  => $isDraft ? 'D' : 'S',
                'req_created_date'  => now(),
                'req_code'          => $reqCode,
            ]);

            foreach ($request->subtask_name as $index => $subtaskName) {
                $empId = $request->emp[$index] ?? null;
                $assigneeType = ($empId !== null && $empId !== "0") ? 'ind' : 'dept';

                Task::create([
                    'tsk_req_id'         => $workRequest->req_id,
                    'tsk_assignee_type'  => $assigneeType,
                    'tsk_emp_id'         => ($empId !== null && $empId !== "0") ? $empId : null,
                    'tsk_dept_id'        => $request->dept[$index],
                    'tsk_status'         => 'Pending',
                    'tsk_name'           => $subtaskName,
                    'tsk_description'    => $request->description[$index] ?? null,
                    'tsk_due_date'       => $request->end_date[$index],
                    'tsk_priority'       => $request->priority[$index],
                    'tsk_update_date'    => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('form.index')->with('success', 'สร้างใบสั่งงานเรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'error' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
            ]);
        }
    }
}
