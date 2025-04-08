<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkRequest; // Import the WorkRequest model
use Illuminate\Support\Facades\DB; // Import DB facade
use App\Models\Task; // Import Task model

class ReportController extends Controller
{
    /*
    * showReportStat()
    * show the report statistics page
    * @input : -
    * @output : show report statistics page
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-04-05
    */
    public function showReportStat()
    {
        // ดึงข้อมูลเริ่มต้นสำหรับปีและเดือนปัจจุบัน
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // เรียกใช้ getTaskStatistics เพื่อดึงข้อมูลเริ่มต้น
        $request = new Request(['year' => $currentYear, 'month' => $currentMonth]);
        $statistics = $this->getTaskStatistics($request)->getData();

        // สร้าง Request object สำหรับ getTaskStatisticsCompany
        $companyRequest = new Request(['year' => $currentYear, 'month' => $currentMonth]);
        $coStatistics = $this->getTaskStatisticsCompany($companyRequest)->getData();

        // ส่งข้อมูลไปยัง View
        return view('report.report_statistic', compact('statistics', 'coStatistics'));
    }
    /*
    * showReportTable()
    * show the report table page
    * @input : -
    * @output : show report table page
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-04-05
    */
    public function showReportTable()
    {
        $workRequests = WorkRequest::with(['employee', 'department', 'tasks.employee', 'tasks.department'])
            ->get();

        // หากต้องการกรองข้อมูล tasks เฉพาะที่ตรงกับ req_id ของแต่ละ WorkRequest
        foreach ($workRequests as $workRequest) {
            $workRequest->tasks = $workRequest->tasks->where('tsk_req_id', $workRequest->req_id);
        }

        return view('report.report_table', compact('workRequests'));
    }

    /*
    * getTaskStatistics(Request $request)
    * get work request statistics for the employee
    * @input : year, month
    * @output : Filtered work requests in statistics and create bar chart
    * @author : Supasit Meedecha 66160098
    * @Create Date : 2025-04-07
    */
    public function getTaskStatistics(Request $request)
    {
        $user = session('user'); // ดึงข้อมูลผู้ใช้จาก session
        $userId = $user->emp_id; // ใช้ emp_id ของผู้ใช้

        // รับค่าปีและเดือนจาก request
        $year = $request->input('year');
        $month = $request->input('month');

        // ดึงข้อมูลงานของผู้ใช้
        $tasks = Task::where('tsk_emp_id', $userId);

        // กรองข้อมูลตามปีและเดือน
        if ($year) {
            $tasks->whereYear('tsk_due_date', $year - 543);
        }
        if ($month && $month != 'all') {
            $tasks->whereMonth('tsk_due_date', $month);
        }

        $tasks = $tasks->get();

        // แยกประเภทงาน
        $completedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Completed' && $task->tsk_completed_date !== null;
        });

        $delayedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Completed' &&
                $task->tsk_completed_date !== null &&
                $task->tsk_completed_date > $task->tsk_due_date; // เปรียบเทียบวันที่
        });

        $rejectedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Rejected';
        });

        // สร้างสถิติ
        $statistics = [
            'total' => $tasks->count(),
            'completed' => $completedTasks->count(),
            'delayed' => $delayedTasks->count(),
            'rejected' => $rejectedTasks->count(),
        ];

        return response()->json($statistics); // ส่งข้อมูลกลับในรูปแบบ JSON
    }
    /*
    * getTaskStatisticsCompany(Request $request)
    * get work request statistics for the company
    * @input : year, month
    * @output : Filtered work requests in statistics and create bar chart
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-04-07
    */
    public function getTaskStatisticsCompany(Request $request)
    {
        $tasks = Task::query();

        $year = $request->input('year');
        $month = $request->input('month');

        if ($year) {
            $tasks->whereYear('tsk_due_date', $year - 543);
        }
        if ($month && $month != 'all') {
            $tasks->whereMonth('tsk_due_date', $month);
        }

        $tasks = $tasks->get();
        // ดึงข้อมูลงานของผู้ใช้

        // แยกประเภทงาน
        $completedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Completed' &&
                $task->tsk_completed_date !== null;
        });

        $delayedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Completed' &&
                $task->tsk_completed_date !== null &&
                $task->tsk_completed_date > $task->tsk_due_date; // เปรียบเทียบวันที่
        });

        $rejectedTasks = $tasks->filter(function ($task) {
            return $task->tsk_status === 'Rejected';
        });

        // สร้างสถิติ
        $coStatistics = [
            'total' => $tasks->count(),
            'completed' => $completedTasks->count(),
            'delayed' => $delayedTasks->count(),
            'rejected' => $rejectedTasks->count(),
        ];

        return response()->json($coStatistics);
    }
    /*
     * getDepartmentTaskStatistics(Request $request)
     * Filter work requests based on selected year and month
     * @input : year, month
     * @output : Filtered work requests in statistics and create bar chart
     * @author : Supasit Meedecha 66160098
     * @Create Date : 2025-04-06
     * @Update Date : 2025-04-08
     */

    public function getDepartmentTaskStatistics(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        // ดึงข้อมูลงานทั้งหมดพร้อมข้อมูลแผนก
        $tasks = Task::with('department');

        // กรองข้อมูลตามปีและเดือน
        if ($year) {
            $tasks->whereYear('tsk_due_date', $year);
        }
        if ($month && $month != 'all') {
            $tasks->whereMonth('tsk_due_date', $month);
        }

        $tasks = $tasks->get();

        // จัดกลุ่มข้อมูลตามแผนก
        $groupedByDepartment = $tasks->groupBy('tsk_dept_id');

        $labels = [];
        $completedData = [];
        $delayedData = [];
        $rejectedData = [];

        foreach ($groupedByDepartment as $deptId => $tasksGroup) {
            $departmentName = $tasksGroup->first()->department->dept_name ?? 'ไม่ทราบชื่อแผนก';

            $completed = $tasksGroup->filter(function ($task) {
                return $task->tsk_status === 'Completed' && $task->tsk_completed_date !== null;
            })->count();

            $delayed = $tasksGroup->filter(function ($task) {
                return $task->tsk_status === 'Completed' &&
                    $task->tsk_completed_date !== null &&
                    $task->tsk_completed_date > $task->tsk_due_date;
            })->count();

            $rejected = $tasksGroup->filter(function ($task) {
                return $task->tsk_status === 'Rejected';
            })->count();

            $labels[] = $departmentName;
            $completedData[] = $completed;
            $delayedData[] = $delayed;
            $rejectedData[] = $rejected;
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'งานที่ทำเสร็จสิ้น',
                    'data' => $completedData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.8)',
                ],
                [
                    'label' => 'งานที่ส่งล่าช้า',
                    'data' => $delayedData,
                    'backgroundColor' => 'rgba(255, 206, 86, 0.8)',
                ],
                [
                    'label' => 'งานที่ปฏิเสธ',
                    'data' => $rejectedData,
                    'backgroundColor' => 'rgba(153, 102, 255, 0.8)',
                ],
            ],
        ]);
    }

}
