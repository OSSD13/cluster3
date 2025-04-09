{{-- 
* archive.blade.php
* แสดงรายการงานที่จัดเก็บทั้งหมด, แยกตามสถานะงาน (มอบหมาย, ได้รับมอบหมาย)
* @input : $completedRequests, $rejectedRequests, $completedTasks, $rejectedTasks, $workRequests
* @output : แสดงตารางรายการงานที่เสร็จสิ้นแล้วและงานที่ถูกปฏิเสธ
* @author : Saruta Saisuwan 66160375
* @Create Date : 2025-03-20
--}}
@extends('layouts.employee_layouts')
@section('content')
<div class="content">
  <h3 class="mb-0" style="color: #4B49AC;">รายการงานที่จัดเก็บ</h3>
  <div class="custom-box">
    <nav class="navbar">
      <div class="container-fluid">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active custom-tabArc " href="#sent" data-bs-toggle="tab" style="border: none;">งานที่มอบหมาย</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-tabArc " href="#assign" data-bs-toggle="tab" style="border: none;">งานที่ได้รับมอบหมาย</a>
          </li>
        </ul>
        <div class="position-relative" style="width: 300px;">
          <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3"></i>
          <input type="text" name="search" id="searchInput" class="form-control ps-5 rounded-4 shadow-sm" placeholder="Search">
        </div>
      </div>
    </nav>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="sent">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="col-5">ชื่อใบงาน</th>
              <th class="col-3">วันที่สร้าง</th>
              <th class="col-3">วันที่เสร็จสิ้น</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($completedRequests as $tasks)
            <tr class="clickable-row" data-href="{{ route('archive_detail', ['id' => $tasks->req_id]) }}">
              <td>{{ $tasks->req_name}}</td>
              <td class="text-black">{{ \Carbon\Carbon::parse($tasks->req_created_date)->locale(locale: 'th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
              <td class="text-success">{{ \Carbon\Carbon::parse($tasks->req_completed_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
            </tr>
            @endforeach
            @foreach ($rejectedRequests as $tasks)
            <tr class="clickable-row" data-href="{{ route('archive_detail', ['id' => $tasks->req_id]) }}">
              <td>{{ $tasks->req_name}}</td>
              <td class="text-black">{{ \Carbon\Carbon::parse($tasks->req_created_date)->locale(locale: 'th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
              <td class="text-danger">งานถูกปฏิเสธ</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="assign">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="col-3">ชื่อใบงาน</th>
              <th class="col-3">ชื่องาน</th>
              <th class="col-2">ความสำคัญ</th>
              <th class="col-2">วันที่เสร็จสิ้น</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($completedTasks as $task)
            <tr class="clickable-row" data-href="{{ route('archive_detail_self', ['id' => $task->tsk_req_id ,'empId' => $task->tsk_emp_id]) }}">
              <td>{{$workRequests[$task->tsk_req_id]->req_name ?? '-' }}</td>
              <td>{{ $task->tsk_name }}</td>
              <td>
                @if($task->tsk_priority == 'H' )
                <span class="badge rounded-pill text-white" style="background-color: #E70000">สูง</span>
                @endif
                @if($task->tsk_priority == 'M' )
                <span class="badge rounded-pill text-white " style="background-color: #F28D28;">กลาง</span>
                @endif
                @if($task->tsk_priority == 'L' )
                <span class="badge rounded-pill text-white " style="background-color: #26BC00;">ต่ำ</span>
                @endif
              </td>
              <td class="text-success">{{ \Carbon\Carbon::parse($task->tsk_completed_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
            </tr>
            @endforeach
            @foreach ($rejectedTasks as $task)
            <tr class="clickable-row" data-href="{{ route('archive_detail_self', ['id' => $task->tsk_req_id , 'empId' => $task->tsk_emp_id ]) }}">
              <td>{{$workRequests[$task->tsk_req_id]->req_name ?? '-' }}</td>
              <td>{{ $task->tsk_name }}</td>
              <td>
                @if($task->tsk_priority == 'H' )
                <span class="badge rounded-pill text-white" style="background-color: #E70000">สูง</span>
                @endif
                @if($task->tsk_priority == 'M' )
                <span class="badge rounded-pill text-white " style="background-color: #F28D28;">กลาง</span>
                @endif
                @if($task->tsk_priority == 'L' )
                <span class="badge rounded-pill text-white " style="background-color: #26BC00;">ต่ำ</span>
                @endif
              </td>
              <td class="text-danger">คุณปฏิเสธงาน</td>
            </tr>
            @endforeach
          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll(".clickable-row");
    rows.forEach(row => {
      row.addEventListener("click", function() {
        const url = this.getAttribute("data-href");
        if (url) {
          window.location.href = url;
        }
      });
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    // คลิกแถวเพื่อเปิดหน้า
    const rows = document.querySelectorAll(".clickable-row");
    rows.forEach(row => {
      row.addEventListener("click", function() {
        const url = this.getAttribute("data-href");
        if (url) {
          window.location.href = url;
        }
      });
    });

    // 🔍 ฟังก์ชันค้นหา
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
      const keyword = this.value.toLowerCase();

      // เลือกทุก tbody ของทุกแท็บ
      document.querySelectorAll('.tab-content table tbody').forEach(tbody => {
        tbody.querySelectorAll('tr').forEach(row => {
          const text = row.innerText.toLowerCase();
          row.style.display = text.includes(keyword) ? '' : 'none';
        });
      });
    });
  });
</script>
@endsection