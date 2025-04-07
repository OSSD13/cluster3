 <!-- home_showdetail.blade.php
Display form create subtask by employee
@input : st_name st_description st_due_date st_priority และ st_assignee
@output : form create subtask
@author : Saruta saisuwan 66160375
@Create Date : 2025-02-09 -->


 @extends('layouts.employee_layouts')
 @section('content')


 <div class="content">

     <div class="col">

         <div class="d-flex justify-content-between align-items-center">
             <h3 class="mb-3">รายการงาน</h3>
             <ul class="nav nav-tabs">
                 <li class="nav-item">
                     <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#myTasks">ใบงานของฉัน</button>
                 </li>
                 <li class="nav-item">
                     <button class="nav-link" data-bs-toggle="tab" data-bs-target="#teamTasks">ใบงานของแผนก</button>
                 </li>
             </ul>
         </div>

     </div>
     <div class=" shadow-sm p-4 rounded">
         <table class="table">
             <thead>
                 <tr>
                     <th class="col-3">
                         <div class="d-flex gap-2">
                             <ion-icon name="arrow-back-outline" size="large"></ion-icon>
                             <h5 style="color: #AFB2BA; margin: 0;">รายละเอียดใบงาน</h5>
                         </div>

                     <th class="col-9 text-secondary"></th>
                 </tr>
             </thead>
             <form action="{{url ('/show')}}" method="post" onsubmit="comfirm_save(event)">
                 @csrf
                 @method('put')
                 <input type="hidden" name="tsk_id" value="{{$task->first()->tsk_id}}">
                 <tbody>
                     <tr>
                         <th scope=" row">ชื่อใบงาน</th>
                         @foreach ( $workRequest as $work )
                         @if($work->req_id == $task->first()->tsk_req_id)
                         <td>{{ $work->req_name }}</td>
                         @endif
                         @endforeach
                     </tr>
                     <tr>
                         <th scope="row">ชื่องาน</th>

                         <td>{{ $task->first()->tsk_name }}</td>
                     </tr>
                     <tr>
                         <th scope="row">รายละเอียด</th>
                         <td>
                             {{ $task->first()->tsk_description }}
                         </td>
                     </tr>
                     <tr>
                         <th scope="row">ผู้มอบหมาย</th>
                         <td>
                             <div class="d-flex gap-2">
                                 <ion-icon name="person-circle-outline" size="large"></ion-icon>
                                 <!-- @foreach($emp as $employee)
                                 @if($employee->emp_id == $task->first()->tsk_req_id  )
                                 {{ $employee->emp_name }}
                                 @endif
                                 @endforeach
                                 @foreach($dept as $department)
                                 @if($department->emp_id == $task->first()->tsk_emp_id && $workRequest[$task->first()-tsk_req_id]->req_create_type == 'dept' )
                                 {{ $department->dept_name }}
                                 @endif
                                 @endforeach -->
                                 @php
                                 $workRequest = $taskWith->workRequest;
                                 @endphp
                                 <p>

                                     @if($workRequest->req_create_type == 'ind')
                                     {{ $workRequest->employee->emp_name ?? '-' }}
                                     @elseif($workRequest->req_create_type == 'dept')
                                     {{ $workRequest->department->dept_name ?? '-' }}
                                     @else
                                     ไม่ทราบผู้สร้าง
                                     @endif
                                 </p>
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <th scope="row">ความสำคัญ</th>
                         <td>
                             @if($task->first()->tsk_priority == 'H' )
                             <span class="badge rounded-pill text-white text-bg-danger">สูง</span>
                             @endif
                             @if($task->first()->tsk_priority == 'M' )
                             <span class="badge rounded-pill text-white text-bg-warning">กลาง</span>
                             @endif
                             @if($task->first()->tsk_priority == 'L' )
                             <span class="badge rounded-pill text-white text-bg-success">ต่ำ</span>
                             @endif
                         </td>
                     </tr>
                     <tr>
                         <th scope="row">สถานะ</th>
                         <!-- Input hidden ที่จะเก็บสถานะ -->
                         <input type="hidden" name="tsk_status" id="tsk_status" value="{{ $task->first()->tsk_status }}">
                         <td>
                             <div class="btn-group dropend">
                                 <!-- ปุ่มแสดงสถานะ -->
                                 <button id="statusButton" type="button" class="status-btn">
                                     @if ($task->first()->tsk_status == 'Pending')
                                     <span id="statusIndicator" class="status-dot bg-secondary"></span> รอดำเนินการ
                                     @elseif($task->first()->tsk_status == 'In Progress')
                                     <span id="statusIndicator" class="status-dot bg-warning"></span> กำลังดำเนินการ
                                     @elseif($task->first()->tsk_status == 'Completed')
                                     <span id="statusIndicator" class="status-dot bg-success"></span> เสร็จสิ้น
                                     @endif


                                     <!-- <span id="statusIndicator" class="status-dot bg-secondary"></span> {{ $task->first()->tsk_status }} -->
                                 </button>
                                 <!-- ปุ่ม Dropdown -->
                                 <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none;">
                                     <span class="visually-hidden">Toggle Dropend</span>
                                 </button>
                                 <!-- รายการสถานะที่เลือกได้ -->
                                 <ul class="dropdown-menu">
                                     <li><a class="dropdown-item" href="#" onclick="changeStatus('รอดำเนินการ', 'bg-secondary', 'Pending')">รอดำเนินการ</a></li>
                                     <li><a class="dropdown-item" href="#" onclick="changeStatus('กำลังดำเนินการ', 'bg-warning', 'In Progress')">กำลังดำเนินการ</a></li>
                                     <li><a class="dropdown-item" href="#" onclick="changeStatus('เสร็จสิ้น', 'bg-success', 'Completed')">เสร็จสิ้น</a></li>
                                 </ul>
                             </div>
                         </td>
                     </tr>

                     <tr>
                         <th scope="row">กำหนดส่ง</th>
                         <!-- <td class="text-danger">{{ \Carbon\Carbon::parse($task->first()->tsk_due_date)->format('d F Y H:i') }}</td> -->
                         <td class="text-danger">{{ \Carbon\Carbon::parse($task->first()->tsk_due_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>

                     </tr>
                     <tr>
                         <th scope="row">วันที่เสร็จสิ้น</th>
                         <td>-</td>
                     </tr>
                     <tr>
                         <th scope="row mt-3">ความคิดเห็น</th>
                         <td>
                             <div class="d-flex gap-2">
                                 <ion-icon name="person-circle-outline" size="large"></ion-icon>
                                 <div class="input-group my-2">
                                     <div class="form-floating">
                                         @if (($task->first()->tsk_comment) == null)
                                         <div class="form-floating">
                                             <textarea class="form-control" placeholder="เพิ่มความคิดเห็น" id="floatingTextarea2" name="tsk_comment" value ="{{$task->first()->tsk_comment}}" style="height: 100px"></textarea>
                                             <label for="floatingTextarea2">เพิ่มความคิดเห็น...</label>
                                         </div>
                                         @else
                                         <div class="form-floating">
                                             <textarea class="form-control" placeholder="เพิ่มความคิดเห็น" id="floatingTextarea2" name="tsk_comment" value ="{{$task->first()->tsk_comment}}" style="height: 100px">{{ $task->first()->tsk_comment }}</textarea>
                                             <label for="floatingTextarea2">ความคิดเห็นเดิม</label>
                                         </div>

                                         @endif

                                         <!-- @if ($task->first()->tsk_comment == '')
                                         <textarea class="form-control" placeholder="เพิ่มความคิดเห็น" id="floatingTextarea2" style="height: 100px" ></textarea>
                                         <label for="floatingTextarea2" name="tsk_comment" value ="{{ $task->first()->tsk_comment }}" >เพิ่มความคิดเห็น...</label>
                                         @endif
                                         @if ($task->first()->tsk_comment != null)
                                         <textarea class="form-control" placeholder="{{ $task->first()->tsk_comment }}" id="floatingTextarea2" style="height: 100px" ></textarea>
                                         <label for="floatingTextarea2" name="tsk_comment" value ="{{ $task->first()->tsk_comment }}" >{{ $task->first()->tsk_comment }}</label>
                                         @endif -->

                                     </div>
                                 </div>
                             </div>
                         </td>
                     </tr>
                 </tbody>


         </table>
         <div class="container text-center">
             <div class="row align-items-start">
                 <div class="col d-flex justify-content-start">
                     <a class="link-underline-dark icon-link-hover " href="#" style="color:black">
                         ดูรายละเอียดเพิ่มเติม
                     </a>
                 </div>
                 <div class="col d-flex justify-content-end">
                     <!-- ปุ่มปฏิเสธ -->
                     <button type="button" class="btn me-2" style="background-color:#E70000; color: white;" onclick="comfirm_reject(event)">ปฏิเสธ</button>

                     <!-- ปุ่มบันทึก -->
                     <button type="submit" class="btn" style="background-color:#4B49AC; color: white;">บันทึก</button>
                 </div>
             </div>
         </div>
     </div>
     </form>



     <script>
         function changeStatus(statusText, statusColor, statusValue) {
             // เปลี่ยนข้อความในปุ่ม
             const statusButton = document.getElementById("statusButton");
             statusButton.innerHTML = `<span id="statusIndicator" class="status-dot ${statusColor}"></span> ${statusText}`;

             // เปลี่ยนค่าของฟอร์มที่ต้องการส่ง (ค่า value ของ input hidden)
             document.getElementById("tsk_status").value = statusValue; // กำหนดค่า value ของ input hidden
         }
     </script>

     <script>
         function comfirm_save(event) {
             event.preventDefault();
             const swalWithBootstrapButtons = Swal.mixin({
                 customClass: {
                     confirmButton: "swal-confirm btn ",
                     cancelButton: "btn btn-danger me-5 "
                 },
                 buttonsStyling: false
             });
             swalWithBootstrapButtons.fire({
                 title: "คุณต้องการเปลี่ยนแปลงข้อมูลใช่หรือไม่?",
                 text: "",
                 icon: "warning",
                 showCancelButton: true,

                 confirmButtonText: "ยืนยัน",
                 cancelButtonText: "ยกเลิก",
                 reverseButtons: true


             }).then((result) => {
                 if (result.isConfirmed) {
                     event.target.submit();
                 }
             });
         }
         //  $(document).ready(function() {})
     </script>
     <script>
         async function comfirm_reject(event) {
             event.preventDefault(); // ป้องกันการ submit ฟอร์มโดยทันที

             const {
                 value: reason
             } = await Swal.fire({
                 title: "กรุณากรอกเหตุผลการปฏิเสธ",
                 input: "text",
                 inputLabel: " ",
                 showCancelButton: true,
                 cancelButtonText: 'ยกเลิก', // กำหนดข้อความปุ่มยกเลิก
                 confirmButtonText: 'ยืนยัน', // กำหนดข้อความปุ่มยืนยัน
                 inputValidator: (value) => {
                     if (!value) {
                         return "กรุณากรอกเหตุผล!";
                     }
                 }
             });

             if (reason) {
                 // ดำเนินการกับเหตุผลที่กรอก เช่น ส่งข้อมูลไปยังเซิร์ฟเวอร์
                 // ตัวอย่างการแสดงข้อความยืนยันการปฏิเสธ
                 Swal.fire(`เหตุผลการปฏิเสธ: ${reason}`);
             }
         }

         $(document).ready(function() {
             // เพิ่มการเชื่อมต่อ event ที่ต้องการเรียกใช้งานฟังก์ชัน comfirm_reject
             // เช่นถ้าคลิกปุ่ม ก็สามารถใส่โค้ดนี้
             $('#yourButtonID').click(function(event) {
                 comfirm_reject(event);
             });
         });
     </script>
     @endsection