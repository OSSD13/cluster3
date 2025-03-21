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
        <h3>รายการงาน</h3>
        <div class="nav-tabs-container">
            <ul class="nav nav-tabs" id="taskTabs">
                <!-- แท็บสำหรับเลือกประเภทของงาน -->
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
                                <!-- ตัวอย่างข้อมูลใบงาน -->
                                <tr class="table">
                                    <td class="col-3" style="padding-left:32px;">งานของเป้ย</td>
                                    <td class="col-3">ห้องน้ำต้องการตัว</td>
                                    <td class="col-2">ปาล์ม</td>
                                    <td class="col-2">ระดับจักรวาล</td>
                                    <td class="col-2">32/12/2658</td>
                                </tr>
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
                            <tbody></tbody>
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
                            <tbody></tbody>
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
                            <tbody></tbody>
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
                            <tbody></tbody>
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
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
