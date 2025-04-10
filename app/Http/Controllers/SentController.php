<?php
/*
* SentController
* แสดงใบงานที่ส่งแล้ว และดำเนินการอนุมัติ
* @author : Sarocha Dokyeesun 66160097
* @Create Date : 2025-04-09
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkRequest;
use Carbon\Carbon;

class SentController extends Controller
{


    /*
    * sent()
    * แสดงรายการใบงานที่ส่งแล้ว โดยเรียงใบงาน Completed/Rejected ขึ้นก่อน
    * และใบงานอื่นเรียงตามกำหนดส่งงานเร็วสุด
    * @input : -
    * @output : sentRequests (Collection ที่เรียงลำดับแล้ว)
    * @author : Sarocha Dokyeesun
    * @Create Date : 2025-04-09
    */
    public function sent()
    {
        $user = session('user');
        $employeeId = $user->emp_id ?? null;

        // ดึงใบงานที่ส่งแล้ว พร้อมงานย่อยทั้งหมด
        $requests = WorkRequest::with('tasks')
            ->where('req_emp_id', $employeeId)
            ->where('req_draft_status', 'S')
            ->get();

        foreach ($requests as $req) {
            $statuses = $req->tasks->pluck('tsk_status')->toArray();

            if (count($statuses) === 0) {
                continue; // ข้ามถ้ายังไม่มีงานย่อย
            }

            $newStatus = $req->req_status; // ค่าเริ่มต้น

            if (collect($statuses)->every(fn($s) => $s === 'Completed')) {
                $newStatus = 'Completed';
            } elseif (in_array('Rejected', $statuses)) {
                $newStatus = 'Rejected';
            } elseif (in_array('In Progress', $statuses)) {
                $newStatus = 'In Progress';
            } elseif (collect($statuses)->every(fn($s) => $s === 'Pending')) {
                $newStatus = 'Pending';
            } else {
                $newStatus = 'In Progress'; // ถ้ามีสถานะผสมหรือไม่เข้าข่ายด้านบน
            }

            // ถ้ามีการเปลี่ยนแปลงสถานะจริง → ค่อย save
            if ($req->req_status !== $newStatus) {
                $req->req_status = $newStatus;
                $req->save();
            }
        }

        // โหลดข้อมูลใหม่หลังอัปเดตสถานะ เพื่อให้ view เห็นข้อมูลล่าสุด
        $updatedRequests = WorkRequest::with('tasks')
            ->where('req_emp_id', $employeeId)
            ->where('req_draft_status', 'S')
            ->get();

        $sorted = $updatedRequests->sortBy(function ($req) {
            $priority = in_array($req->req_status, ['Completed', 'Rejected']) ? 0 : 1;

            $earliestDueDate = $req->tasks
                ->pluck('tsk_due_date')
                ->filter()
                ->map(fn($d) => Carbon::parse($d))
                ->sort()
                ->first() ?? Carbon::now()->addYears(5);

            return [$priority, $earliestDueDate];
        });

        return view('sent', [
            'sentRequests' => $sorted->values()
        ]);
    }


    /*
    * sentDetail()
    * แสดงรายละเอียดใบงานและงานย่อยทั้งหมด
    * @input : $id (รหัสใบงาน)
    * @output : reqName, reqDescription, tasks, reqEmployeeName
    * @author : Sarocha Dokyeesun
    * @Create Date : 2025-04-09
    */
    public function SentDetail($id)
    {
        $workRequest = WorkRequest::with(['tasks.employee'])->where('req_id', $id)->first();

        if (!$workRequest) {
            abort(404, 'Work request not found.');
        }

        $reqName = $workRequest->req_name ?? 'ไม่มีชื่อ';
        $reqDescription = $workRequest->req_description ?? 'ไม่มีคำอธิบาย';
        $tasks = $workRequest->tasks;
        $reqEmployeeName = $workRequest->employee->emp_name ?? 'ไม่มีข้อมูล';

        return view('detail', compact('reqName', 'reqDescription', 'tasks', 'reqEmployeeName'));
    }

    /*
    * approve()
    * เปลี่ยนสถานะใบงานจาก S เป็น A หากสถานะเป็น Completed หรือ Rejected
    * @input : $id (รหัสใบงาน)
    * @output : JSON success / error message สำหรับการเปลี่ยนสถานะ
    * @author : Sarocha Dokyeesun
    * @Create Date : 2025-04-09
    */
    public function approve($id)
    {
        $workRequest = WorkRequest::findOrFail($id);

        if ($workRequest->req_status === 'Completed' || $workRequest->req_status === 'Rejected') {
            $workRequest->req_draft_status = 'A'; // อัปเดตสถานะ
            $workRequest->req_completed_date = now(); // เก็บวันที่และเวลาเมื่อกดยอมรับ
            $workRequest->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'ไม่สามารถอนุมัติได้'], 400);
    }
}
