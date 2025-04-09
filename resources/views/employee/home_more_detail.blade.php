{{--
* send_detail.blade.php
* Layout for detail dashboard
*
* @input : -
* @output : employee_layouts.blade.php
* @author : Kidrakon Rattanahiran 66160342
* @Create Date : 2025-03-21
--}}
@extends('layouts.employee_layouts')
@section('content')

<div class="content">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">รายการงาน</h3>
        <!-- <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#myTasks">ใบงานของฉัน</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#teamTasks">ใบงานของแผนก</button>
            </li>
        </ul> -->
    </div>

    <!-- Tab Content -->
    <div class="tab-content margin-top: 0 !important">
        <!-- My Tasks Tab -->
        <div class="tab-pane fade show active" style="margin-top: 0; padding-top: 0;">
            <!-- Task Table Card -->
            <div class="card shadow-sm mb-4 border-top-left-radius: 0; border-top-right-radius: 0;">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <a href="javascript:history.back()" class="back-button d-flex align-items-center text-decoration-none mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left ms-4 mt-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            <span class="ms-4 fs-5">รายละเอียดใบงานทั้งหมด</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th class="text-center" style="width: 10%">ลำดับงาน</th>
                                    <th style="width: 60%">ชื่องาน</th>
                                    <th style="width: 30%">ผู้รับมอบหมาย</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                <tr class="task-row" data-target="#details{{ $task->tsk_id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="task-title">{{ $task->tsk_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="profile-circle me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                                    </svg>
                                                </div>
                                                <span style="width: 300px; ">{{ $task->employee->emp_name  ??  $task->department->dept_name }}</span>
                                            </div>
                                            <span class="task-title custom-spacing">หมายเหตุ</span>
                                            <span class="dropdown-indicator">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr id="details{{ $task->tsk_id }}" class="detail-row no-display">
                                    <td colspan="3">
                                        <div class="task-details p-3 bg-light border-top">
                                            <h5 class="mb-3">หมายเหตุ:</h5>
                                            <p>{{ $task->tsk_comment }}</p>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Team Tasks Tab -->
@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make task rows clickable to toggle details
        const taskRows = document.querySelectorAll('.task-row');
        taskRows.forEach(row => {
            row.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const detailsRow = document.querySelector(targetId);
                const indicator = this.querySelector('.dropdown-indicator');

                // Toggle the active class on the row
                this.classList.toggle('active');

                // Toggle the rotation of the dropdown indicator
                indicator.classList.toggle('open');

                // Toggle the visibility of the details row
                if (detailsRow.classList.contains('no-display')) {
                    detailsRow.classList.remove('no-display');
                } else {
                    detailsRow.classList.add('no-display');
                }
            });
        });
    });
</script>

@endsection