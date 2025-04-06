{{--
* employee_task_list.blade.php
* Display task list for employees and departments
* @input : -
* @output : Task list interface with categorized task tabs
* @author : Pacharathorn Pimngoen 66160235
* @Create Date : 2025-03-22
--}}

@extends('layouts.employee_layouts')
@section('content') 

<div class="d-flex">
    <div class="content w-100">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="m-0">รายการงาน</h3>
            <ul class="nav nav-tabs" id="taskTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#myTasks">ใบงานของฉัน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#departmentTasks">ใบงานของแผนก</a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
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
                        <table class="table">
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
                                        <tr>
                                            <td class="col-3" style="padding-left:32px;">{{ $task->tsk_name }}</td>
                                            <td class="col-3">{{ $task->tsk_description }}</td>
                                            <td class="col-2">
                                                {{ $workRequests[$task->tsk_req_id]->req_create_type == 'ind' ? 'บุคคล' : 'แผนก' }}
                                            </td>
                                            <td class="col-2">{{ $task->tsk_priority }}</td>
                                            <td class="col-2">{{ $task->tsk_due_date }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่มีข้อมูล</td> <!-- ปรับ colspan เป็น 6 -->
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="inprogress">
                        <table class="table">
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
                                        <tr>
                                            <td class="col-3" style="padding-left:32px;">{{ $task->tsk_name }}</td>
                                            <td class="col-3">{{ $task->tsk_description }}</td>
                                            <td class="col-2">
                                                {{ $workRequests[$task->tsk_req_id]->req_create_type == 'ind' ? 'บุคคล' : 'แผนก' }}
                                            </td>
                                            <td class="col-2">{{ $task->tsk_priority }}</td>
                                            <td class="col-2">{{ $task->tsk_due_date }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่มีข้อมูล</td> <!-- ปรับ colspan เป็น 6 -->
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="completed">
                        <table class="table">
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
                                        <tr>
                                            <td class="col-3" style="padding-left:32px;">{{ $task->tsk_name }}</td>
                                            <td class="col-3">{{ $task->tsk_description }}</td>
                                            <td class="col-2">
                                                {{ $workRequests[$task->tsk_req_id]->req_create_type == 'ind' ? 'บุคคล' : 'แผนก' }}
                                            </td>
                                            <td class="col-2">{{ $task->tsk_priority }}</td>
                                            <td class="col-2">{{ $task->tsk_due_date }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่มีข้อมูล</td> <!-- ปรับ colspan เป็น 6 -->
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade mt-3" id="departmentTasks">
                <ul class="nav nav-tabs">
                    <!-- แท็บย่อยสำหรับใบงานของแผนก -->
                    <li class="nav-item">
                        <a class="custom-btn active" data-bs-toggle="tab" href="#deptReceived">งานที่ได้รับ</a>
                    </li>
                    <li class="nav-item">
                        <a class="custom-btn" data-bs-toggle="tab" href="#deptInprogress">กำลังดำเนินการ</a>
                    </li>
                    <li class="nav-item">
                        <a class="custom-btn" data-bs-toggle="tab" href="#deptCompleted">เสร็จสิ้น</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" style="border:none;">
                    <div class="tab-pane fade show active" id="deptReceived">
                        <table class="table">
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
                            @if(isset($tasks['received']['dept']) && count($tasks['received']['dept']) > 0)
                                    @foreach ($tasks['received']['dept'] as $task)
                                        <tr>
                                            <td class="col-3" style="padding-left:32px;">{{ $task->tsk_name }}</td>
                                            <td class="col-3">{{ $task->tsk_description }}</td>
                                            <td class="col-2">
                                                {{ $workRequests[$task->tsk_req_id]->req_create_type == 'ind' ? 'บุคคล' : 'แผนก' }}
                                            </td>
                                            <td class="col-2">{{ $task->tsk_priority }}</td>
                                            <td class="col-2">{{ $task->tsk_due_date }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่มีข้อมูล</td> <!-- ปรับ colspan เป็น 6 -->
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="deptInprogress">
                        <table class="table">
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
                                @if(isset($tasks['inprogress']['dept']) && count($tasks['inprogress']['dept']) > 0)
                                    @foreach ($tasks['inprogress']['dept'] as $task)
                                        <tr>
                                            <td class="col-3" style="padding-left:32px;">{{ $task->tsk_name }}</td>
                                            <td class="col-3">{{ $task->tsk_description }}</td>
                                            <td class="col-2">
                                                {{ $workRequests[$task->tsk_req_id]->req_create_type == 'ind' ? 'บุคคล' : 'แผนก' }}
                                            </td>
                                            <td class="col-2">{{ $task->tsk_priority }}</td>
                                            <td class="col-2">{{ $task->tsk_due_date }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่มีข้อมูล</td> <!-- ปรับ colspan เป็น 6 -->
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="deptCompleted">
                        <table class="table">
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
                            @if(isset($tasks['completed']['dept']) && count($tasks['completed']['dept']) > 0)
                                    @foreach ($tasks['completed']['dept'] as $task)
                                        <tr>
                                            <td class="col-3" style="padding-left:32px;">{{ $task->tsk_name }}</td>
                                            <td class="col-3">{{ $task->tsk_description }}</td>
                                            <td class="col-2">
                                                {{ $workRequests[$task->tsk_req_id]->req_create_type == 'ind' ? 'บุคคล' : 'แผนก' }}
                                            </td>
                                            <td class="col-2">{{ $task->tsk_priority }}</td>
                                            <td class="col-2">{{ $task->tsk_due_date }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่มีข้อมูล</td> <!-- ปรับ colspan เป็น 6 -->
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection