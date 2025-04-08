<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Session;
class DraftController extends Controller

{
    public function getShowDraft()
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
public function destroy($id)
{
    $request = WorkRequest::with('tasks')->findOrFail($id);

    // ลบงานย่อยก่อน (ถ้าต้องการลบทั้งหมดที่เกี่ยวข้อง)
    $request->tasks()->delete();

    // ลบใบสั่งงาน
    $request->delete();



    return redirect()->back()->with('success', 'ลบใบสั่งงานสำเร็จแล้ว');
}
}
