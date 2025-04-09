{{-- 
* task_tabs.blade.php
* แสดงแท็บที่ใช้สำหรับเลือกดูรายการใบงานของผู้ใช้และแผนก
* @input : ไม่มี
* @output : แสดงแท็บ "ใบงานของฉัน" และ "ใบงานของแผนก" ซึ่งแสดงผลตามการเลือกแท็บ
* @author : Saruta Saisuwan 66160375
* @Create Date : 2025-04-08
--}}
<div class="d-flex justify-content-between align-items-center">
    <h3 class="m-0">รายการงาน</h3>
    <ul class="nav nav-tabs" id="taskTabs">
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#myTasks">ใบงานของฉัน</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#departmentTasks">ใบงานของแผนก</a>
        </li>
    </ul>
</div>

