@extends('layouts.employee_layouts')
@section('content') 
    <style>
        body { font-family: 'Arial', sans-serif; }
        .sidebar { width: 250px; background: #f8f9fa; height: 100vh; position: fixed; padding: 20px; }
        .content { margin-left: 270px; padding: 20px; }
        .nav-link.active { background-color: #007bff !important; color: white !important; }
    </style>

    <div class="d-flex">
        <div class="content w-100">
            <h3>รายการงาน</h3>
            <ul class="nav nav-tabs" id="taskTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#received">งานที่ได้รับ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#inprogress">กำลังดำเนินการ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#completed">เสร็จสิ้น</a>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="received">
                    <p>แสดงรายการงานที่ได้รับ</p>
                </div>
                <div class="tab-pane fade" id="inprogress">
                    <p>แสดงรายการงานที่กำลังดำเนินการ</p>
                </div>
                <div class="tab-pane fade" id="completed">
                    <p>แสดงรายการงานที่เสร็จสิ้น</p>
                </div>
            </div>
        </div>
    </div>
@endsection
