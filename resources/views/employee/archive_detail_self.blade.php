{{--
* archive_detail_self.blade.php
* Display work request and task details in archive view for self-assigned tasks
* @input : req_id, emp_id
* @output : work request and task details for self view
* @author : Art-anon Phakhananthanon 66160242
* @Create Date : 2025-04-07
--}}

{{--
* Database Tables:
* wrs_work_requests : Table for storing work request data
* Columns: req_id, req_create_type, req_emp_id, req_dept_id, req_status, req_name,
*          req_description, req_draft_status, req_created_date, req_update_date,
*          req_completed_date, req_code
*
* wrs_tasks : Table for storing task data under work requests
* Columns: tsk_id, tsk_req_id, tsk_assignee_type, tsk_emp_id, tsk_dept_id, tsk_status,
*          tsk_name, tsk_description, tsk_due_date, tsk_priority, tsk_update_date,
*          tsk_completed_date, tsk_comment_reject, tsk_comment
*
* wrs_employees : Table for storing employee information
* Columns: emp_dept_id, emp_username, emp_password, emp_name, emp_role,
*          emp_created_date, emp_update_date
--}}

@extends('Layouts.employee_layouts')
@section('content')
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archive Details My</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('public/css/archive_detail.css') }}" rel="stylesheet">

</head>

<body>
        {{-- Header Section --}}
        <h3 class="text-primary">รายการงาน</h3>

        {{-- Back Navigation Section --}}
        <div class="d-flex align-items-center mt-3" style="color: #AFB2BA; font-size: 1.4rem; margin-left: 20px;">
            <a href="{{ route('archive.table', ['id' => request()->route('id')]) }}" class="text-decoration-none" style="color: #AFB2BA;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#AFB2BA" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                </svg>
            </a>
            <p class="ms-2 mb-0" style="padding-left: 20px;">รายละเอียดใบงานทั้งหมด</p>
        </div>

        {{-- Work Request Details Section --}}
        <div class="mt-3">
            <div style="border-bottom: 1px solid #E9E9E9; border-top: 1px solid #E9E9E9; padding: 10px 0; margin-left: 20px;" class="d-flex">
                <p class="me-3"><strong>ชื่อใบงาน</strong></p>
                <p style="margin-left: 90px;">{{ $reqName }}</p> <!-- placeholder -->
            </div>
            <div style="padding: 10px 0; margin-left: 20px;" class="d-flex">
                <p class="me-3"><strong>คำอธิบาย</strong></p>
                <p style="margin-left: 90px;">{{ $reqDescription }}</p> <!-- placeholder -->
            </div>
        </div>

        {{-- Tasks Table Section --}}
        <table class="table mt-3" style="border-collapse: separate; border-spacing: 0;">
            {{-- Table Header --}}
            <thead class="table-secondary">
                <tr>
                    <th style="color: #989BA4;">ลำดับงาน</th> <!-- แถบหัวข้อ -->
                    <th style="color: #989BA4;">ชื่องาน</th>
                    <th style="color: #989BA4;">ผู้ได้รับมอบหมาย</th>
                    <th></th>
                </tr>
            </thead>

            {{-- Table Body with Task List --}}
            <tbody>
                @foreach ($tasks as $task)
                {{-- Task Row with Expandable Details --}}
                <tr style="background-color: #F7F7F7; border-bottom: 1px solid #E9E9E9; cursor: pointer;"
                    onclick="toggleDropdown('collapse{{ $loop->iteration }}')">
                    <td style="padding-left: 37px">{{ $loop->iteration }}</td>
                    <td>{{ $task->tsk_name }}</td>
                    <td>
                        <i class="bi bi-person-circle" style="margin-right: 5px;"></i>
                        {{ $task->employee->emp_name ?? 'ไม่มีผู้มอบหมาย' }}
                    </td>
                    <td class="text-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#212529" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding: 0;">
                        <div id="collapse{{ $loop->iteration }}" class="collapse" style="display: none; overflow: hidden; transition: max-height 0.3s ease;">
                        {{-- Dropdown contents --}}
                            {{-- Description --}}
                                <div class="d-flex" style="padding: 10px 0; margin-left: 37px;">
                                    <p class="me-3"><strong>รายละเอียด</strong></p>
                                    <p style="margin-left: 220px;">{{ $task->tsk_description ?? 'ไม่มีคำอธิบาย' }}</p>
                                </div>
                                {{-- Assigned by --}}
                                <div class="d-flex" style="padding: 10px 0; margin-left: 37px; border-top: 1px solid #E9E9E9;">
                                    <p class="me-3"><strong>ผู้มอบหมาย</strong></p>
                                    <p style="margin-left: 220px;">{{ $reqEmployeeName }}</p>
                                </div>
                                {{-- Priority --}}
                                <div class="d-flex" style="padding: 10px 0; margin-left: 37px; border-top: 1px solid #E9E9E9;">
                                    <p class="me-3"><strong>ความสำคัญ</strong></p>
                                    <p style="margin-left: 220px;">
                                        @if ($task->tsk_priority === 'H')
                                            <span style="display: inline-block; background-color: #E70000; color: white; padding: 5px 10px; border-radius: 20px;">สูง</span>
                                        @elseif ($task->tsk_priority === 'M')
                                            <span style="display: inline-block; background-color: #F28D28; color: white; padding: 5px 10px; border-radius: 20px;">ปานกลาง</span>
                                        @elseif ($task->tsk_priority === 'L')
                                            <span style="display: inline-block; background-color: #26BC00; color: white; padding: 5px 10px; border-radius: 20px;">ต่ำ</span>
                                        @else
                                            <span style="color: #AFB2BA;">ไม่มีระดับความสำคัญ</span>
                                        @endif
                                    </p>
                                </div>
                                {{-- Status --}}
                                <div class="d-flex" style="padding: 10px 0; margin-left: 37px; border-top: 1px solid #E9E9E9;">
                                    <p class="me-3"><strong>สถานะ</strong></p>
                                    <p style="margin-left: 253px;">
                                        @if ($task->tsk_status === 'Pending')
                                            <span style="display: inline-flex; align-items: center;">
                                                <span style="width: 18px; height: 18px; background-color: grey; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                                รอดำเนินการ
                                            </span>
                                        @elseif ($task->tsk_status === 'In Progress')
                                            <span style="display: inline-flex; align-items: center;">
                                                <span style="width: 18px; height: 18px; background-color: rgb(0, 72, 255); border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                                กำลังดำเนินการ
                                            </span>
                                        @elseif ($task->tsk_status === 'Completed')
                                            <span style="display: inline-flex; align-items: center;">
                                                <span style="width: 18px; height: 18px; background-color: rgb(51, 255, 0); border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                                เสร็จสิ้น
                                            </span>
                                        @elseif ($task->tsk_status === 'Rejected')
                                            <span style="display: inline-flex; align-items: center;">
                                                <span style="width: 18px; height: 18px; background-color: rgb(255, 0, 0); border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                                ถูกปฏิเสธ
                                            </span>
                                        @else
                                            <span style="color: #AFB2BA;">ไม่มีสถานะ</span>
                                        @endif
                                    </p>
                                </div>
                                {{-- Due Date --}}
                                <div class="d-flex" style="padding: 10px 0; margin-left: 37px; border-top: 1px solid #E9E9E9;">
                                    <p class="me-3"><strong>กำหนดส่ง</strong></p>
                                    <p style="margin-left: 235px; color: #E70000">{{ $task->tsk_due_date ? substr($task->tsk_due_date, 0, 10) : 'ไม่มีข้อมูล' }}</p>
                                </div>
                                {{-- Actual Date --}}
                                <div class="d-flex" style="padding: 10px 0; margin-left: 37px; border-top: 1px solid #E9E9E9;">
                                    <p class="me-3"><strong>กำหนดส่ง</strong></p>
                                    <p style="margin-left: 235px; color: #E70000">
                                        @php
                                            if($task->tsk_due_date) {
                                                $date = \Carbon\Carbon::parse($task->tsk_due_date);
                                                $thaiMonths = [
                                                    1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม',
                                                    4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
                                                    7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน',
                                                    10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
                                                ];
                                                echo $date->format('d ') . $thaiMonths[$date->month] . $date->format(' Y H:i');
                                            } else {
                                                echo 'ไม่มีข้อมูล';
                                            }
                                        @endphp
                                    </p>
                                </div>
                                {{-- Comment --}}
                                <div class="d-flex" style="padding: 10px 0; margin-left: 37px; border-top: 1px solid #E9E9E9;">
                                    <p class="me-3"><strong>ความคิดเห็น</strong></p>
                                    <p style="margin-left: 220px;">{{ $task->tsk_comment ?? 'ไม่มีความคิดเห็น' }}</p>
                                </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    {{-- Dropdown Toggle Function --}}
    <script>
        /*
        * toggleDropdown()
        * Handles expanding and collapsing of task detail sections
        * @input : id (collapse element id)
        * @output : visual changes to expand/collapse sections
        * @author : Art-anon Phakhananthanon 66160242
        * @Create Date : 2025-04-07
        */
        function toggleDropdown(id) {
            const element = document.getElementById(id);
            const button = document.querySelector(`[onclick="toggleDropdown('${id}')"] svg`);
            if (!element.style.maxHeight || element.style.maxHeight === '0px') {
                element.style.display = 'block';
                element.style.maxHeight = element.scrollHeight + 'px';
                button.classList.add('rotated'); // Add class to rotate arrow
            } else {
                element.style.maxHeight = '0';
                button.classList.remove('rotated'); // Remove class to reset arrow
                setTimeout(() => {
                    element.style.display = 'none';
                }, 300); // Match the transition duration
            }
        }

        // Ensure all collapsible elements have maxHeight set to 0 initially
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.collapse').forEach(element => {
                element.style.maxHeight = '0';
            });
        });
    </script>

    {{-- CSS Styles --}}
    <style>
        .rotated {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }
    </style>
    </body>
</html>
@endsection
