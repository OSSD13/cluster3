<?php

namespace App\Http\Controllers;
use App\Models\WorkRequest;
use Illuminate\Support\Facades\Session;

/*
 * Class : DraftController
 * @author : Salsabeela Sa-e 66160349
 * @Create Date : 2025-04-04
 * ควบคุมการทำงานที่เกี่ยวข้องกับการดึงข้อมูลแบบร่างและการลบใบสั่งงาน
 */
class DraftController extends Controller
{
    /*
     * showDraft()
     * แสดงรายการใบสั่งงานแบบร่างที่ผู้ใช้ล็อกอินเป็นผู้สร้าง
     * @input : ไม่มี
     * @output : view draft_list พร้อมข้อมูลใบสั่งงานที่อยู่ในสถานะแบบร่าง
     * @author : Salsabeela Sa-e 66160349
     * @Create Date : 2025-04-04
     */
    public function showDraft()
    {
        // ดึงข้อมูลจาก session
        $user = Session::get('user');

        // ตรวจสอบว่ามีข้อมูลผู้ใช้หรือไม่
        if (!$user) {
            // ถ้าไม่มีข้อมูลผู้ใช้ให้รีไดเร็กต์ไปที่หน้า login
            return redirect('/login');
        }

        // ดึง emp_id ของผู้ใช้ที่ล็อกอิน
        $empId = $user->emp_id;


        $draftRequests = WorkRequest::where('req_emp_id', $empId)
            ->where('req_draft_status', 'D')
            ->withCount('tasks') // นับจำนวนงานย่อยให้เลย
            ->get();

        return view('draft_list', compact('draftRequests'));
    }

    /*
     * delete()
     * ลบใบสั่งงานและงานย่อยที่เกี่ยวข้อง
     * @input : $id (ID ของใบสั่งงานที่ต้องการลบ)
     * @output : redirect กลับพร้อมข้อความสำเร็จ
     * @author : Salsabeela Sa-e 66160349
     * @Create Date : 2025-04-04
     */

    public function delete($id)
    {
        $request = WorkRequest::with('tasks')->findOrFail($id);

        // ลบงานย่อยก่อน (ถ้าต้องการลบทั้งหมดที่เกี่ยวข้อง)
        $request->tasks()->delete();

        // ลบใบสั่งงาน
        $request->delete();



        return redirect()->back()->with('success', 'ลบใบสั่งงานสำเร็จแล้ว');
    }
}
