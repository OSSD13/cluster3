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
                                <div class="d-flex justify-content-end align-items-center mb-4">
                                    <div class="me-2">
                                        <select id="yearDropdown" class="form-select">
                                            @php
                                                $currentYear = date('Y');
                                                $years = range($currentYear - 10, $currentYear); // ตั้งค่าปีย้อนหลัง 10 ปีจนถึงปีปัจจุบัน
                                            @endphp

                                            @foreach ($years as $year)
                                                <option value="{{ $year + 543 }}">{{ $year + 543 }}</option> <!-- แปลงปีเป็น พ.ศ. -->
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <select id="monthDropdown" class="form-select">
                                            @php
                                                $months = [
                                                    '01' => 'ม.ค.',
                                                    '02' => 'ก.พ.',
                                                    '03' => 'มี.ค.',
                                                    '04' => 'เม.ย.',
                                                    '05' => 'พ.ค.',
                                                    '06' => 'มิ.ย.',
                                                    '07' => 'ก.ค.',
                                                    '08' => 'ส.ค.',
                                                    '09' => 'ก.ย.',
                                                    '10' => 'ต.ค.',
                                                    '11' => 'พ.ย.',
                                                    '12' => 'ธ.ค.',
                                                ];
                                            @endphp

                                            @foreach ($months as $key => $month)
                                                <option value="{{ $month }}">{{ $month }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
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
                                        <tr class="main-row">
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
@section('script')
    <script>
        document.getElementById('yearDropdown').addEventListener('change', filterWorkRequests);
        document.getElementById('monthDropdown').addEventListener('change', filterWorkRequests);

        function filterWorkRequests() {
            const year = document.getElementById('yearDropdown').value;
            const month = document.getElementById('monthDropdown').value;

            // ดึงแถวทั้งหมดในตาราง
            const mainRows = document.querySelectorAll('tbody tr.main-row');

            mainRows.forEach(mainRow => {
                const createdDateCell = mainRow.querySelector('td:nth-child(3)'); // เลือกคอลัมน์ "วันที่สร้าง"
                const createdDateText = createdDateCell ? createdDateCell.textContent.trim() : '';

                // เช็คว่าแถวตรงกับปีและเดือนที่เลือกหรือไม่
                const isYearMatch = year ? createdDateText.includes(year) : true;
                const isMonthMatch = month ? createdDateText.includes(month) : true;

                const shouldShowRow = isYearMatch && isMonthMatch;

                // แสดง/ซ่อนแถวหลัก
                mainRow.style.display = shouldShowRow ? '' : 'none';

                // แสดง/ซ่อนแถวที่เป็น task ที่เกี่ยวข้อง
                let next = mainRow.nextElementSibling;
                while (next && !next.classList.contains('main-row')) {
                    next.style.display = shouldShowRow ? '' : 'none';
                    next = next.nextElementSibling;
                }
            });

            // ปรับ rowspan ของแถวหลักให้ถูกต้อง
            mainRows.forEach(mainRow => {
                if (mainRow.style.display === '') {
                    let visibleTaskCount = 0;
                    let next = mainRow.nextElementSibling;
                    while (next && !next.classList.contains('main-row')) {
                        if (next.style.display === '') {
                            visibleTaskCount++;
                        }
                        next = next.nextElementSibling;
                    }
                    const rowspanCell = mainRow.querySelector('td[rowspan]');
                    if (rowspanCell) {
                        rowspanCell.rowSpan = visibleTaskCount + 1; // รวมแถวหลักด้วย
                    }
                }
            });
        }
    </script>
@endsection
