{{--
* home_showdetail.blade.php
* แสดงรายละเอียดของใบงานในระบบ Work Request
* @input : ข้อมูลของงานย่อย เช่น st_name, st_description, st_due_date, st_priority และ st_assignee จากตัวแปร $task และ $emp
* @output : หน้าจอแสดงรายละเอียดใบงานพร้อมปุ่มเปลี่ยนสถานะและแสดงความคิดเห็น
* @author : Saruta Saisuwan 66160375
* @Create Date : 2025-03-20
* @Update Date : 2025-04-10
* @Update By : Naphat Maneechansuk 66160099
--}}

 @extends('layouts.employee_layouts')
 @section('content')
 <link rel="stylesheet" href="{{ asset('public\css\pages\home_show_detail.css') }}">
 <link rel="stylesheet" href="{{ asset('public\css\pages\detail_style.css') }}">
 <div class="containetr-fluid">
     <div class="col">
         <div class="d-flex justify-content-between align-items-center">
             <h3 class="m-0" >รายการงาน</h3>
         </div>

     </div>
     <div class="tab-content">
         @if ($errors->any())
             <div class="alert alert-danger">
                 <ul>
                     @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
         @endif
         <table class="table">
             <thead>
                 <tr>
                     <th class="col-3">
                         <div class="d-flex gap-2">
                         <a href="javascript:history.back()" class="back-button d-flex align-items-center text-decoration-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left ms-4 mt-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            <span class="ms-4 fs-5">รายละเอียดใบงานทั้งหมด</span>
                        </a>
                         </div>

                     <th class="col-9 text-secondary"></th>
                 </tr>
             </thead>
             <form id="taskForm" action="{{ route('update-task', ['id' => $taskWith->tsk_id]) }}" method="post" onsubmit="comfirm_save(event)">
                 @csrf
                 @method('put')
                 <input type="hidden" name="tsk_id" value="{{$task->first()->tsk_id}}">
                 <input type="hidden" name="tsk_comment_reject" id="tsk_comment_reject" value="{{$task->first()->tsk_comment_reject}}">
                 <input type="hidden" name="tsk_emp_id" id="tsk_emp_id" value="{{$emp->emp_id}}">
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
                            <span class="badge rounded-pill text-white" style="background-color: #E70000">สูง</span>
                            @endif
                            @if($task->first()->tsk_priority == 'M' )
                            <span class="badge rounded-pill text-white " style="background-color: #F28D28;">กลาง</span>
                            @endif
                            @if($task->first()->tsk_priority == 'L' )
                            <span class="badge rounded-pill text-white " style="background-color: #26BC00;" >ต่ำ</span>
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
                                 </button>
                                 @if ($task->first()->tsk_status == 'Pending' || $task->first()->tsk_status == 'In Progress')
                                 <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none;">
                                     <span class="visually-hidden">Toggle Dropend</span>
                                 </button>
                                 <ul class="dropdown-menu">
                                     <li><a class="dropdown-item" href="#" onclick="changeStatus('รอดำเนินการ', 'bg-secondary', 'Pending')">รอดำเนินการ</a></li>
                                     <li><a class="dropdown-item" href="#" onclick="changeStatus('กำลังดำเนินการ', 'bg-warning', 'In Progress')">กำลังดำเนินการ</a></li>
                                     <li><a class="dropdown-item" href="#" onclick="changeStatus('เสร็จสิ้น', 'bg-success', 'Completed')">เสร็จสิ้น</a></li>
                                 </ul>
                                 @endif
                             </div>
                         </td>
                     </tr>

                     <tr>
                         <th scope="row">กำหนดส่ง</th>
                         <td class="text-danger">{{ \Carbon\Carbon::parse($task->first()->tsk_due_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
                     </tr>
                     <tr>
                         <th scope="row">วันที่เสร็จสิ้น</th>
                         @if ($task->first()->tsk_completed_date == null)
                         <td class="text-danger">ยังไม่เสร็จสิ้น</td>
                         @else
                         <td class="text-success">{{ \Carbon\Carbon::parse($task->first()->tsk_completed_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
                         @endif
                     </tr>
                     <tr>
                         <th scope="row mt-3">ความคิดเห็น</th>
                         <td>
                             <div class="d-flex gap-2">
                                 <div class="input-group my-2">
                                    <div class="form-floating">
                                        @if ($task->first()->tsk_status != 'Completed' )
                                            @if (($task->first()->tsk_comment) == null )
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="เพิ่มความคิดเห็น" id="floatingTextarea2" name="tsk_comment" value="{{$task->first()->tsk_comment}}" style="height: 100px"></textarea>
                                                <label for="floatingTextarea2">เพิ่มความคิดเห็น...</label>
                                            </div>
                                            @else
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="เพิ่มความคิดเห็น" id="floatingTextarea2" name="tsk_comment" value="{{$task->first()->tsk_comment}}" style="height: 100px">{{ $task->first()->tsk_comment }}</textarea>
                                                <label for="floatingTextarea2">ความคิดเห็นเดิม</label>
                                            </div>
                                            @endif
                                        @else
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="เพิ่มความคิดเห็น" id="floatingTextarea2" name="tsk_comment" value="{{$task->first()->tsk_comment}}" readonly  style="height: 100px">{{ $task->first()->tsk_comment }}</textarea>
                                                <label for="floatingTextarea2">ความคิดเห็น</label>
                                            </div>
                                        @endif
                                    </div>
                                 </div>
                             </div>
                         </td>
                     </tr>
                 </tbody>
         </table>
         <div class="container text-center">
             <div class="row align-items-start">
                 <div class="col d-flex justify-content-start mb-3">
                     <a class="link-underline-dark icon-link-hover " href="{{ route('more_detail', ['id' => $task->first()->tsk_req_id]) }}" style="color:black">
                         ดูรายละเอียดเพิ่มเติม
                     </a>
                 </div>
                 @if ($task->first()->tsk_status == 'Pending' || $task->first()->tsk_status == 'In Progress')
                 <div class="col d-flex justify-content-end mb-3">
                     <!-- ปุ่มปฏิเสธ -->
                     <button type="button" class="btn me-2" style="background-color:#E70000; color: white;" onclick="comfirm_reject(event)">ปฏิเสธ</button>

                     <!-- ปุ่มบันทึก -->
                     <button type="submit" class="btn" style="background-color:#4B49AC; color: white;">บันทึก</button>
                 </div>
                 @endif

             </div>
         </div>
     </div>
     </form>
 </div>

 @endsection
 @section('script')

 <script>
     function changeStatus(statusText, statusColor, statusValue) {
         // เปลี่ยนข้อความในปุ่ม
         const statusButton = document.getElementById("statusButton");
         statusButton.innerHTML = `<span id="statusIndicator" class="status-dot ${statusColor}"></span> ${statusText}`;

         // เปลี่ยนค่าของฟอร์มที่ต้องการส่ง (ค่า value ของ input hidden)
         document.getElementById("tsk_status").value = statusValue; // กำหนดค่า value ของ input hidden
     }


     function comfirm_save(event) {
         event.preventDefault(); // ป้องกันการ submit ฟอร์มโดยทันที

         const commentField = document.getElementById('floatingTextarea2');
         const maxLength = 1000;
         const currentLength = commentField.value.length;

         // ตรวจสอบว่าความยาวของข้อความเกินกำหนดหรือไม่
         if (currentLength > maxLength) {
             Swal.fire({
                 icon: 'error',
                 title: 'ข้อความยาวเกินไป',
                 text: 'กรุณาแก้ไขข้อความให้ไม่เกิน 1000 ตัวอักษร',
                 confirmButtonText: 'ตกลง',
                 customClass: {
                     confirmButton: 'btn btn-primary'
                 },
                 buttonsStyling: false
             });
             return; // หยุดการทำงาน ไม่ให้ส่งฟอร์ม
         }

         // หากข้อความไม่เกินกำหนด ให้แสดง SweetAlert ยืนยันการบันทึก
         const swalWithBootstrapButtons = Swal.mixin({
             customClass: {
                title: "swal-title-small",
                 confirmButton: "swal-confirm btn ",
                 cancelButton: "btn btn-danger me-5 "
             },
             buttonsStyling: false
         });

         swalWithBootstrapButtons.fire({
             title: "คุณต้องการบันทึกข้อมูลหรือไม่?",
             text: "",
             icon: "warning",
             showCancelButton: true,
             confirmButtonText: "ยืนยัน",
             cancelButtonText: "ยกเลิก",
             reverseButtons: true
         }).then((result) => {
             if (result.isConfirmed) {
                 document.getElementById("taskForm").submit(); // ส่งฟอร์ม
             }
         });
     }

      /*
         * comfirm_reject()
         * comfirm_reject Employee
         * @input : Employee name
         * @output : Employee name in table
         * @author : Naphat Maneechansuk 66160099
         * @Create Date : 2025-04-10
     */
    async function comfirm_reject(event) {
    event.preventDefault(); // ป้องกันการ submit ฟอร์มโดยทันที

    const { value: reason } = await Swal.fire({
        title: "กรุณากรอกเหตุผลการปฏิเสธ",
        input: "text",
        inputLabel: " ",
        showCancelButton: true,
        cancelButtonText: 'ยกเลิก',
        confirmButtonText: 'ยืนยัน',
        reverseButtons: true,
        customClass: {
            confirmButton: 'swal-reject btn ',   // ✅ สีเขียวสำหรับ "ยืนยัน"
            cancelButton: 'btn btn-danger me-5'  // ✅ สีเทาสำหรับ "ยกเลิก"
        },
        buttonsStyling: false, // ต้องใส่เพื่อให้ใช้ customClass แทนของ default
        inputValidator: (value) => {
            if (!value) {
                return "กรุณากรอกเหตุผล!";
            }
        }
    });

    if (reason) {
        document.getElementById("tsk_status").value = "Rejected";
        document.getElementById("tsk_comment_reject").value = reason;
        document.getElementById("taskForm").submit();
    }
}

    /*
         * comfirm_reject()
         * comfirm_reject Employee
         * @input : Employee name
         * @output : Employee name in table
         * @author : Naphat Maneechansuk 66160099
         * @Create Date : 2025-04-10
     */
document.getElementById('floatingTextarea2').addEventListener('input', function (e) {
    const maxLength = 500;
    const currentLength = e.target.value.length;

    if (currentLength > maxLength) {
        e.target.value = e.target.value.substring(0, maxLength);

        // ใช้ SweetAlert แทน alert และให้หายไปเองใน 3 วินาที
        Swal.fire({
            icon: 'warning',
            title: 'ข้อความยาวเกินไป',
            text: 'คุณสามารถใส่ข้อความได้สูงสุด ' + maxLength + ' ตัวอักษร',
            showConfirmButton: false, // ซ่อนปุ่มตกลง
            timer: 3000, // ตั้งเวลา 3 วินาที
            timerProgressBar: true, // แสดงแถบเวลา
            customClass: {
                popup: 'swal-popup-small' // เพิ่มคลาสสำหรับปรับแต่ง (ถ้าต้องการ)
            }
        });
    }
});

 </script>
 @endsection
