{{-- 
* my_tasks.blade.php
* แสดงรายการงานที่ได้รับมอบหมายของผู้ใช้ แบ่งตามสถานะงาน (งานที่ได้รับ, กำลังดำเนินการ, เสร็จสิ้น)
* @input : $tasks (ข้อมูลงานที่ได้รับมอบหมายของผู้ใช้ในแต่ละสถานะ)
* @output : แสดงตารางรายการงานของผู้ใช้ที่แบ่งตามสถานะการดำเนินการ
* @author : Saruta Saisuwan 66160375
* @Create Date : 2025-04-08
--}}
<div class="tab-pane fade show active mt-3" id="myTasks">
    <ul class="nav nav-tabs">
        <!-- แท็บย่อยสำหรับงานของฉัน -->
        <li class="nav-item">
            <a class="custom-btn active" data-bs-toggle="tab" href="#received">งานที่ได้รับ</a>
        </li>
        <li class="nav-item">
            <a class="custom-btn" data-bs-toggle="tab" href="#inprogress">กำลังดำเนินการ</a>
        </li>
        <li class="nav-item">
            <a class="custom-btn" data-bs-toggle="tab" href="#completed">เสร็จสิ้น</a>
        </li>
    </ul>
    <div class="tab-content mt-3" style="border:none;">
        <div class="tab-pane fade show active" id="received">
            <!-- ตารางแสดงงานที่ได้รับ -->
            <table class="table table-hover">
                <thead>
                    <tr class="table-secondary">
                        <th class="col-3" style="padding-left:32px;">ชื่อใบงาน</th>
                        <th class="col-3">ชื่องาน</th>
                        <th class="col-2">ผู้มอบหมาย</th>
                        <th class="col-2">ความสำคัญ</th>
                        <th class="col-2">กำหนดส่ง</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($tasks['received']['my']) && count($tasks['received']['my']) > 0)
                    @foreach ($tasks['received']['my'] as $task)
                    <tr class="clickable-row" data-href="{{ route('show', ['id' => $task->tsk_id]) }}">
                        <td class="col-3" style="padding-left:32px;">{{ $workRequests[$task->tsk_req_id]->req_name}}</td>
                        <td class="col-3">{{ $task->tsk_name }}</td>
                        <td class="col-2">
                            @if ($task->workRequest->req_create_type == 'ind')
                            {{ $task->workRequest->employee->emp_name }}
                            <!-- {{ $task->workRequest->employee->emp_id }} -->
                            @endif
                            @if ($task->workRequest->req_create_type == 'dept')
                            {{ $task->workRequest->department->dept_name }}
                            @endif
                        </td>
                        <td>
                            @if($task->tsk_priority == 'H' )
                            <span class="badge rounded-pill text-white" style="background-color: #E70000">สูง</span>
                            @endif
                            @if($task->tsk_priority == 'M' )
                            <span class="badge rounded-pill text-white " style="background-color: #F28D28;">กลาง</span>
                            @endif
                            @if($task->tsk_priority == 'L' )
                            <span class="badge rounded-pill text-white " style="background-color: #26BC00;" >ต่ำ</span>
                            @endif
                        </td>
                        <td class="text-danger">{{ \Carbon\Carbon::parse($task->tsk_due_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
                        <!-- <td class="col-2">{{ $task->tsk_due_date }}</td> -->
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">ไม่มีงานที่ได้รับมอบหมาย</td> <!-- ปรับ colspan เป็น 6 -->
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="inprogress">
            <table class="table table-hover">
                <thead>
                    <tr class="table-secondary">
                        <th class="col-3" style="padding-left:32px;">ชื่อใบงาน</th>
                        <th class="col-3">ชื่องาน</th>
                        <th class="col-2">ผู้มอบหมาย</th>
                        <th class="col-2">ความสำคัญ</th>
                        <th class="col-2">กำหนดส่ง</th>
                    </tr>
                </thead>
                <tbody>

                    @if(isset($tasks['inprogress']['my']) && count($tasks['inprogress']['my']) > 0)
                    @foreach ($tasks['inprogress']['my'] as $task)
                    <tr class="clickable-row" data-href="{{ route('show', ['id' => $task->tsk_id]) }}">
                        <td class="col-3" style="padding-left:32px;">{{ $workRequests[$task->tsk_req_id]->req_name}}</td>
                        <td class="col-3">{{ $task->tsk_name }}</td>
                        <td class="col-2">
                            @if ($task->workRequest->req_create_type == 'ind')
                            {{ $task->workRequest->employee->emp_name }}
                            @endif
                            @if ($task->workRequest->req_create_type == 'dept')
                            {{ $task->workRequest->department->dept_name }}
                            @endif
                        </td>
                        <td>
                            @if($task->tsk_priority == 'H' )
                            <span class="badge rounded-pill text-white" style="background-color: #E70000"">สูง</span>
                            @endif
                            @if($task->tsk_priority == 'M' )
                            <span class="badge rounded-pill text-white" style="background-color: #F28D28;">กลาง</span>
                            @endif
                            @if($task->tsk_priority == 'L' )
                            <span class="badge rounded-pill text-white "style="background-color: #26BC00;"   >ต่ำ</span>
                            @endif
                        </td>
                        <td class="text-danger">{{ \Carbon\Carbon::parse($task->tsk_due_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">ไม่มีงานที่ได้รับมอบหมาย</td> <!-- ปรับ colspan เป็น 6 -->
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="completed">
            <table class="table table-hover">
                <thead>
                    <tr class="table-secondary">
                        <th class="col-3" style="padding-left:32px;">ชื่อใบงาน</th>
                        <th class="col-3">ชื่องาน</th>
                        <th class="col-2">ผู้มอบหมาย</th>
                        <th class="col-2">ความสำคัญ</th>
                        <th class="col-2">กำหนดส่ง</th>
                    </tr>
                </thead>
                <tbody>

                    @if(isset($tasks['completed']['my']) && count($tasks['completed']['my']) > 0)
                    @foreach ($tasks['completed']['my'] as $task)
                    @if ( $workRequests[$task->tsk_req_id]->req_status != 'Completed' )
                    <tr class="clickable-row" data-href="{{ route('show', ['id' => $task->tsk_id]) }}">
                        <td class="col-3" style="padding-left:32px;">{{ $workRequests[$task->tsk_req_id]->req_name}}</td>
                        <td class="col-3">{{ $task->tsk_name }}</td>
                        <td class="col-2">
                            @if ($task->workRequest->req_create_type == 'ind')
                            {{ $task->workRequest->employee->emp_name }}
                            @endif
                            @if ($task->workRequest->req_create_type == 'dept')
                            {{ $task->workRequest->department->dept_name }}
                            @endif
                        </td>
                        <td>
                            @if($task->tsk_priority == 'H' )
                            <span class="badge rounded-pill text-white " style="background-color: #E70000">สูง</span>
                            @endif
                            @if($task->tsk_priority == 'M' )
                            <span class="badge rounded-pill text-white " style="background-color: #F28D28;">กลาง</span>
                            @endif
                            @if($task->tsk_priority == 'L' )
                            <span class="badge rounded-pill text-white " style="background-color: #26BC00;">ต่ำ</span>
                            @endif
                        </td>
                        <td class="text-danger">{{ \Carbon\Carbon::parse($task->tsk_due_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
                    </tr>
                    @endif
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">ไม่มีงานที่ได้รับมอบหมาย</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>