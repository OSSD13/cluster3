@extends('layouts.employee_layouts')

@section('content')
    <div class="container-fluid">
        <!-- Main Content Only -->
        <div class="row">
            <div class="col-12">
                <h2 class="main-header">สรุปรายการ Work Request ประจำวันที่ 1 มี.ค. 68</h2>

                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <h5 style="color: #4B49AC;">จำนวนทั้งสิ้น {{ count($workRequests) }} รายการ</h5>
                            </div>
                            <div class="d-flex">
                                <div class="dropdown me-2">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        กรุณาเลือก
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                        <li><a class="dropdown-item" href="#">วัน</a></li>
                                        <li><a class="dropdown-item" href="#">เดือน</a></li>
                                        <li><a class="dropdown-item" href="#">ปี</a></li>
                                    </ul>
                                </div>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-calendar"></i>
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-active">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">เลขที่</th>
                                        <th scope="col">วันที่สร้าง</th>
                                        <th scope="col">ผู้ขอ</th>
                                        <th scope="col">แผนก</th>
                                        <th scope="col">งาน</th>
                                        <th scope="col">ผู้ดำเนินการ</th>
                                        <th scope="col">กำหนดเสร็จ</th>
                                        <th scope="col">สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($workRequests as $index => $workRequest)
                                        <tr>
                                            <td rowspan="{{ count($workRequest->tasks) + 1 }}">{{ $index + 1 }}</td>
                                            <td rowspan="{{ count($workRequest->tasks) + 1 }}">{{ $workRequest->req_code }}
                                            </td>
                                            <td rowspan="{{ count($workRequest->tasks) + 1 }}">
                                                {{ $workRequest->thai_created_date }}</td>
                                            <td rowspan="{{ count($workRequest->tasks) + 1 }}">
                                                {{ $workRequest->employee->emp_name ?? '-' }}</td>
                                            <td rowspan="{{ count($workRequest->tasks) + 1 }}">
                                                {{ $workRequest->department->dept_name ?? '-' }}</td>
                                        </tr>
                                        @foreach ($workRequest->tasks as $task)
                                            <tr>
                                                <td>{{ $task->tsk_name }}</td>
                                                <td>
                                                    @if ($task->tsk_assignee_type === 'ind')
                                                        <!-- ถ้า tsk_assignee_type เป็น 'ind' แสดงชื่อผู้รับผิดชอบ -->
                                                        {{ $task->employee->emp_name ?? '-' }}
                                                    @elseif ($task->tsk_assignee_type === 'dept')
                                                        <!-- ถ้า tsk_assignee_type เป็น 'dept' แสดงชื่อแผนก -->
                                                        {{ $task->department->dept_name ?? '-' }}
                                                    @else
                                                        <!-- ถ้าไม่ใช่ 'ind' หรือ 'dept' แสดงค่าอื่น ๆ หรือค่าว่าง -->
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $task->thai_task_due_date }}</td>
                                                    @if ($task->tsk_status === 'Pending')
                                                        <td><span class="status-dot-1"></span>รอดำเนินการ</td>
                                                    @elseif ($task->tsk_status === 'In Progress')
                                                        <td><span class="status-dot-2"></span>กำลังดำเนินการ</td>
                                                    @elseif ($task->tsk_status === 'Completed')
                                                        <td><span class="status-dot-3"></span>เสร็จสิ้น</td>
                                                    @elseif ($task->tsk_status === 'Rejected')
                                                        <td><span class="status-dot-4"></span>ปฏิเสธ</td>
                                                    @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
