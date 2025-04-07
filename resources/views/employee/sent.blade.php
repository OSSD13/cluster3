@extends('layouts.employee_layouts')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('public\css\pages\archive_table.css') }}">
</head>
<div class="content">
    <h3 class="mb-3" style="color: #4B49AC;">รายการงาน</h3>
    <div class="custom-box">
        <div class="container-fluid d-flex justify-content-end mb-3 mt-2">
            <div class="position-relative" style="width: 300px;">
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                <input type="text" class="form-control ps-5 rounded-4 shadow-sm" placeholder="Search">
            </div>
    </div>
        <table class="table">
            <thead>
                <tr class="table">
                    <th class="col-4">ชื่อใบงาน</th>
                    <th class="col-3">ชื่องาน</th>
                    <th class="col-1">สถานะ</th>
                    <th class="col-1">ความสำคัญ</th>
                    <th class="col-1">วันที่เสร็จสิ้น</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                </tr>
            </tbody>
        </table>


    </div>
</div>


@endsection