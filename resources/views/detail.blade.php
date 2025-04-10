{{-- 
* detail.blade.php
* หน้ารายละเอียดใบงานและงานย่อยทั้งหมด
*
* @input : $reqName, $reqDescription, $tasks, $reqEmployeeName
* @output : แสดงรายละเอียดใบงานและรายการงานย่อยแบบขยายได้
* @author : [ชื่อคุณ] [รหัสนักศึกษา]
* @Create Date : 2025-04-09
--}}

@extends('layouts.employee_layouts')
@section('content')
    {{-- Header Section --}}
    <div class="h3" style="color: #4B49AC;">
        รายการงาน
    </div>

    {{-- Back Navigation Section --}}
    <div class="d-flex align-items-center mt-3" style="color: #AFB2BA; font-size: 1.4rem; margin-left: 20px;">
        <a href="{{ route('sent', ['id' => request()->route('id')]) }}" class="text-decoration-none" style="color: #AFB2BA;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#AFB2BA" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z" />
            </svg>
        </a>
        <p class="ms-2 mb-0" style="padding-left: 20px;">รายละเอียดใบงานทั้งหมด</p>
    </div>

    {{-- Work Request Details Section --}}
    <div class="mt-3">
        <div style="border-bottom: 1px solid #E9E9E9; border-top: 1px solid #E9E9E9; padding: 10px 0; margin-left: 20px;"
            class="d-flex">
            <p class="me-3"><strong>ชื่อใบงาน</strong></p>
            <p style="margin-left: 90px;">{{ $reqName }}</p> <!-- placeholder -->
        </div>
        <div style="padding: 10px 0; margin-left: 20px;" class="d-flex">
            <p class="me-3"><strong>คำอธิบาย</strong></p>
            <p style="margin-left: 90px;">{{ $reqDescription }}</p> <!-- placeholder -->
        </div>
        @php
            // หาใบงานแรกที่ถูกปฏิเสธ
            $rejectedIndex = null;
            $rejectedComment = null;

            foreach ($tasks as $index => $task) {
                if ($task->tsk_status === 'Rejected') {
                    $rejectedIndex = $index + 1; // เริ่มที่ 1
                    $rejectedComment = $task->tsk_comment_reject ?? 'ไม่มีความคิดเห็น';
                    break;
                }
            }
        @endphp

        @if ($rejectedIndex)
            <div class="d-flex" style="padding: 10px 0; margin-left: 20px; border-top: 1px solid #E9E9E9;">
                <p class="me-3"><strong>เหตุผลการปฏิเสธ (ลำดับงานที่{{ $rejectedIndex }})</strong></p>
                <p style="margin-left: 35px;">{{ $rejectedComment }}</p>
            </div>
        @endif
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
                <tr style="border-bottom: 1px solid #E9E9E9; cursor: pointer;" id="header{{ $loop->iteration }}"
                    onclick="toggleDropdown('collapse{{ $loop->iteration }}', 'header{{ $loop->iteration }}')"
                    @if ($task->tsk_status === 'Rejected') data-rejected="true" @endif>
                    <td style="padding-left: 37px">{{ $loop->iteration }}</td>
                    <td>{{ $task->tsk_name }}</td>
                    <td>
                        <i class="bi bi-person-circle" style="margin-right: 5px;"></i>
                        {{ $task->employee->emp_name ?? 'ไม่มีผู้มอบหมาย' }}
                    </td>
                    <td class="text-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#212529"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </td>
                </tr>
                {{-- Expandable Content Section --}}
                <tr>
                    <td colspan="4" style="padding: 0;">
                        <div id="collapse{{ $loop->iteration }}" class="collapse"
                            style="display: none; overflow: hidden; transition: max-height 0.3s ease;">
                            {{-- Task Details Items --}}
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
                                        <span
                                            style="display: inline-block; background-color: #E70000; color: white; padding: 5px 10px; border-radius: 20px;">สูง</span>
                                    @elseif ($task->tsk_priority === 'M')
                                        <span
                                            style="display: inline-block; background-color: #F28D28; color: white; padding: 5px 10px; border-radius: 20px;">ปานกลาง</span>
                                    @elseif ($task->tsk_priority === 'L')
                                        <span
                                            style="display: inline-block; background-color: #26BC00; color: white; padding: 5px 10px; border-radius: 20px;">ต่ำ</span>
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
                                            <span
                                                style="width: 18px; height: 18px; background-color: grey; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                            รอดำเนินการ
                                        </span>
                                    @elseif ($task->tsk_status === 'In Progress')
                                        <span style="display: inline-flex; align-items: center;">
                                            <span
                                                style="width: 18px; height: 18px; background-color: rgb(0, 72, 255); border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                            กำลังดำเนินการ
                                        </span>
                                    @elseif ($task->tsk_status === 'Completed')
                                        <span style="display: inline-flex; align-items: center;">
                                            <span
                                                style="width: 18px; height: 18px; background-color: rgb(51, 255, 0); border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                                            เสร็จสิ้น
                                        </span>
                                    @elseif ($task->tsk_status === 'Rejected')
                                        <span style="display: inline-flex; align-items: center;">
                                            <span
                                                style="width: 18px; height: 18px; background-color: rgb(255, 0, 0); border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
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
                                <p style="margin-left: 235px; color: #E70000">
                                    @php
                                        if ($task->tsk_due_date) {
                                            $date = \Carbon\Carbon::parse($task->tsk_due_date);
                                            $thaiMonths = [
                                                1 => 'มกราคม',
                                                2 => 'กุมภาพันธ์',
                                                3 => 'มีนาคม',
                                                4 => 'เมษายน',
                                                5 => 'พฤษภาคม',
                                                6 => 'มิถุนายน',
                                                7 => 'กรกฎาคม',
                                                8 => 'สิงหาคม',
                                                9 => 'กันยายน',
                                                10 => 'ตุลาคม',
                                                11 => 'พฤศจิกายน',
                                                12 => 'ธันวาคม',
                                            ];
                                            echo $date->format('d ') .
                                                $thaiMonths[$date->month] .
                                                $date->format(' Y H:i');
                                        } else {
                                            echo 'ไม่มีข้อมูล';
                                        }
                                    @endphp
                                </p>
                            </div>
                            {{-- Actual Date --}}
                            <div class="d-flex" style="padding: 10px 0; margin-left: 37px; border-top: 1px solid #E9E9E9;">
                                <p class="me-3"><strong>วันที่เสร็จสิ้น</strong></p>
                                <p style="margin-left: 220px;">{{ $task->tsk_completed_date ?? 'ไม่มีข้อมูล' }}</p>
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
         * @input : id (collapse element id), headerId (header row id)
         * @output : visual changes to expand/collapse sections
         * @author : Art-anon Phakhananthanon 66160242
         * @Create Date : 2025-04-06
         */
        function toggleDropdown(id, headerId) {
            const element = document.getElementById(id);
            const header = document.getElementById(headerId);
            const button = document.querySelector(`[onclick="toggleDropdown('${id}', '${headerId}')"] svg`);
            if (!element.style.maxHeight || element.style.maxHeight === '0px') {
                element.style.display = 'block';
                element.style.maxHeight = element.scrollHeight + 'px';
                button.classList.add('rotated');
                if (header.dataset.rejected === "true") {
                    header.style.backgroundColor = '#FFB7B7';
                }
            } else {
                element.style.maxHeight = '0';
                button.classList.remove('rotated');
                setTimeout(() => {
                    element.style.display = 'none';
                    if (header.dataset.rejected === "true") {
                        header.style.backgroundColor = ''; // Reset to default
                    }
                }, 300); // Match the transition duration
            }
        }

        // Initialize collapse elements
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.collapse').forEach(element => {
                element.style.maxHeight = '0';
            });
        });
    </script>


    {{-- * CSS Styles
* กำหนด style การหมุนไอคอนและรูปแบบอื่น ๆ สำหรับ collapsible row
*
* @input : ไม่มี
* @output : รูปแบบ UI เมื่อคลิกเปิด/ปิดงานย่อย --}}
    <style>
        .rotated {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }
    </style>
@endsection
