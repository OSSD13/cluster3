<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkRequest;
class DraftController extends Controller

{
    public function getShowDraft()
{
    $userId = Auth::id();

    $draftRequests = WorkRequest::where('req_draft_status', 'D')
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
