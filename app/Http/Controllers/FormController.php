<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Department, Employee, WorkRequest, Task};
use Illuminate\Support\Facades\{DB, Auth};

class FormController extends Controller
{
    /**
     * Show form for creating a new work request.
     */
    public function index()
    {
        $dept = Department::with('employees')->get();
        return view('create_form', compact('dept'));
    }

    /**
     * Return employee list by department ID.
     */
    public function empData($id)
    {
        $emp = Employee::where('emp_dept_id', $id)->get();
        return response()->json($emp);
    }

    /**
     * Handle storing new work request and its tasks.
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
            'emp'              => 'required|array',
            'emp.*'            => 'nullable|integer',
            'priority'         => 'required|array',
            'priority.*'       => 'required|in:L,M,H',
            'end_date'         => 'required|array',
            'end_date.*'       => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            $isDraft = $request->input('submit_type') === 'draft';
            $employeeId = Auth::check() ? Auth::user()->emp_id : 1;

            $workRequest = WorkRequest::create([
                'req_create_type'   => $request->input('creator_status'), // ind / dept
                'req_emp_id'        => $employeeId,
                'req_dept_id'       => null,
                'req_status'        => 'Pending',
                'req_name'          => $request->input('task_name'),
                'req_description'   => $request->input('task_description'),
                'req_draft_status'  => $isDraft ? 'D' : 'S',
                'req_created_date'  => now(),
            ]);

            foreach ($request->subtask_name as $index => $subtaskName) {
                $empId = $request->emp[$index] ?? 0;
                $assigneeType = $empId != 0 ? 'ind' : 'dept';

                Task::create([
                    'tsk_req_id'         => $workRequest->req_id,
                    'tsk_assignee_type'  => $assigneeType,
                    'tsk_emp_id'         => $empId != 0 ? $empId : null,
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
