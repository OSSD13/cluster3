{{--
* employee_task_list.blade.php
* Display task list for employees and departments
* @input : -
* @output : Task list interface with categorized task tabs
* @author : Pacharathorn Pimngoen 66160235
* @Create Date : 2025-03-22
--}}

@extends('layouts.employee_layouts')
@section('content')
<div class="d-flex">
    <div class="content w-100">
        @include('components.tab_task')
        <div class="tab-content">
            @include('components.home_my_task', ['tasks' => $tasks, 'workRequests' => $workRequests,'employees' => $employees,'departments' => $departments, 'allTask' => $allTask])
            @include('components.home_dept_task', ['tasks' => $tasks, 'workRequests' => $workRequests,'employees' => $employees,'departments' => $departments, 'allTask' => $allTask])

        </div>
    </div>
</div>
@endsection
@section('script')
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
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // อ่านค่าพารามิเตอร์จาก URL
        const params = new URLSearchParams(window.location.search);
        const activeTab = params.get("tab") || "myTasks";

        // หาตัวแท็บที่ต้องการเปิด
        const triggerEl = document.querySelector(`a[href="#${activeTab}"]`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show(); // แสดงแท็บ
        }
    });
</script>
@endsection         
            