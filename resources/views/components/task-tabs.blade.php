{{-- 
* components/task-tabs.blade.php
* Task tabs (my / department)
--}}

@php
    use Illuminate\Support\Str;
@endphp

{{-- resources/views/components/task-tabs.blade.php --}}
<div class="col">
    <div class="d-flex justify-content-between align-items-center">
        <h3>รายการงาน</h3>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#myTasks">ใบงานของฉัน</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#departmentTasks">ใบงานของแผนก</button>
            </li>
        </ul>
    </div>
</div>

