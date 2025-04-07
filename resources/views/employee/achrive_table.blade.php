@extends('layouts.employee_layouts')

@section('content')


<div class="content">
  <h3 class="mb-3" style="color: #4B49AC;">รายการงานที่จัดเก็บ</h3>
  <div class="custom-box">
    <nav class="navbar">
      <div class="container-fluid">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active custom-tab " href="#sent" data-bs-toggle="tab" style="border: none;">งานที่มอบหมาย</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-tab " href="#assign" data-bs-toggle="tab" style="border: none;">งานที่ได้รับมอบหมาย</a>
          </li>
        </ul>
        <div class="position-relative" style="width: 300px;">
          <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3"></i>
          <input type="text" class="form-control ps-5 rounded-4 shadow-sm" placeholder="Search">
        </div>
      </div>
    </nav>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="sent">
        <table class="table">
          <thead>
            <tr>
              <th class="col-5">ชื่อใบงาน</th>
              <th class="col-3">วันที่สร้าง</th>
              <th class="col-3">วันที่เสร็จสิ้น</th>
            </tr>
          </thead>
          <tbody> 
          @foreach ($completedRequests as $tasks)
            <tr>
              <td>{{ $tasks->req_name}}</td>
              <td>{{ $tasks->req_created_date }}</td>
              <td>{{ $tasks->req_completed_date }}</td>
            </tr>
            @endforeach
            @foreach ($rejectedRequests as $tasks)
            <tr>
              <td>{{ $tasks->req_name}}</td>
              <td>{{ $tasks->req_created_date }}</td>
              <td>{{ $tasks->req_completed_date }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="assign">
        <table class="table">
          <thead>
          <tr>
              <th class="col-3">ชื่อใบงาน</th>
              <th class="col-3">ชื่องาน</th>
              <th class="col-2">ความสำคัญ</th>
              <th class="col-2">วันที่เสร็จสิ้น</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($completedTasks as $tasks)
            <tr>
            @foreach($workRequests as $workRequest)
            @if ($tasks->tsk_req_id == $workRequest->req_id)
            <td>{{ $workRequest->req_name}}</td>
            @endif
            @endforeach
              <td>{{ $tasks->tsk_name }}</td>
              <td>{{ $tasks->tsk_priority }}</td>
              <td>{{ $tasks->tsk_completed_date }}</td>
            </tr>
            @endforeach
            @foreach ($rejectedTasks as $tasks)
            <tr>
            @foreach($workRequests as $workRequest)
            @if ($tasks->tsk_req_id == $workRequest->req_id)
            <td>{{ $workRequest->req_name}}</td>
            @endif
            @endforeach
              <td>{{ $tasks->tsk_name }}</td>
              <td>{{ $tasks->tsk_priority }}</td>
              <td>{{ $tasks->tsk_completed_date }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection