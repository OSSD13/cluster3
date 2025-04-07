@extends('layouts.employee_layouts')
@section('content') 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>

    <style>
        th {
            color: #989BA4 !important;
        }
        h3 {
            font-family: 'TH Sarabun New', sans-serif !important;
            font-weight: bold;
            font-size: 36px;
            color: #4B49AC;
        }
        .custom-btn.active {
            background: none;
            border: none;
            font-size: 18px;
            font-weight: bold;
            color: #4B49AC;
            text-decoration: underline;
            text-decoration-thickness: 3px;  /* ความหนาของเส้นใต้ */
            text-underline-offset: 4px;   /* ระยะห่างจากตัวอักษร */
            outline: none;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            margin-left: 20px;
            cursor: pointer;
        }
        .custom-btn {
            background: none;
            border: none;
            font-size: 18px;
            font-weight: bold;
            color: #6c757d;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            margin-left: 20px;
            cursor: pointer;
            text-decoration: none; /* ลบเส้นใต้ */
        }

        .custom-btn:active, 
        .custom-btn:focus {
            color: #4B49AC;
            text-decoration: underline;
            text-decoration-thickness: 3px;  /* ความหนาของเส้นใต้ */
            text-underline-offset: 4px;   /* ระยะห่างจากตัวอักษร */
            outline: none;
        }
        .nav-tabs {
            border-bottom: none;
        }
        .nav-tabs .nav-link {
            font-size: 18px;
            font-weight: bold;
            color: #6c757d;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
        }
        .nav-tabs .nav-link.active {
            background-color: #4B49AC;
            color: white;
            border: none;
        }
        .tab-content {
            border: 1px solid #ddd;
            border-radius: 0 0 8px 8px;
            padding: 0px;
            background: white;
        }
        .custom-box {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }
        table thead {
            background-color: #d3d3d3;
            color: black;
        }
        table tbody {
            background-color: white;
        }
        .nav-tabs-container {
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>

<div class="d-flex">
    <div class="content w-100">
        <h3>รายการงาน</h3>
        <div class="nav-tabs-container">
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
                        <table class="table">
                            <thead>
                                <tr class="table-secondary" >
                                    <th class="col-3" style="padding-left:32px;">ชื่อใบงาน</th>
                                    <th class="col-3">ชื่องาน</th>
                                    <th class="col-2">ผู้มอบหมาย</th>
                                    <th class="col-2">ความสำคัญ</th>
                                    <th class="col-2">กำหนดส่ง</th>
                                </tr>
                                <tr class="table" >
                                    <td class="col-3" style="padding-left:32px;">งานของเป้ย</td>
                                    <td class="col-3">ห้องน้ำต้องการตัว</td>
                                    <td class="col-2">ปาล์ม</td>
                                    <td class="col-2">ระดับจักรวาล</td>
                                    <td class="col-2">32/12/2658</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="inprogress">
                        <table class="table">
                            <thead>
                                <tr class="table-secondary" >
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
                                <tr class="table-secondary" >
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
                                <tr class="table-secondary" >
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
                                <tr class="table-secondary" >
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
                                <tr class="table-secondary" >
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
