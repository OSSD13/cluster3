{{--
* report_table.blade.php
* Display form show table report work request
* @input : workRequest, task
* @output : form show table report work request
* @input : dept_name
* @output : new department
* @author : Natthanan Sirisurayut 66160352
* @Create Date : 2025-04-06
* @Update Date : 2025-04-07
* @Update By : Naphat Maneechansuk 66160099
*
--}}
@extends('layouts.employee_layouts')

@section('content')
    <div class="container-fluid">
        <!-- Main Content Only -->
        <div class="row">
            <div class="col-12">
                <h2 class="main-header">
                    สรุปรายการ Work Request <span id="selectedMonth"></span> <span id="selectedYear"></span>
                </h2>

                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <h5 style="color: #4B49AC;">
                                    <!-- แสดงจำนวนงานที่กรองแล้ว -->
                                    จำนวนทั้งสิ้น <span id="totalWorkRequests">{{ count($workRequests) }}</span> รายการ
                                    จากทั้งหมด {{ count($workRequests) }} รายการ
                                </h5>
                            </div>
                            <div class="d-flex">
                                <div class="d-flex justify-content-end align-items-center mb-4">
                                    <div class="me-2">
                                        <select id="yearDropdown" class="form-select">
                                            <option value="" selected>-</option> <!-- Default option for year -->
                                            @php
                                                $currentYear = date('Y');
                                                $years = range($currentYear, $currentYear - 10); // ตั้งค่าปีจากล่าสุดไปเก่าสุด
                                            @endphp

                                            @foreach ($years as $year)
                                                <option value="{{ $year + 543 }}">{{ $year + 543 }}</option>
                                                <!-- แปลงปีเป็น พ.ศ. -->
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <select id="monthDropdown" class="form-select">
                                            <option value="" selected>-</option> <!-- Default option for month -->
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
         /*
         * filterWorkRequests()
         * Filter work requests based on selected year and month
         * @input : year, month
         * @output : Filtered work requests in table
         * @author : Naphat Maneechansuk 66160099
         * @Create Date : 2025-04-06
         * @Update Date : 2025-04-07
         */
        const monthMap = {
            'ม.ค.': 'มกราคม',
            'ก.พ.': 'กุมภาพันธ์',
            'มี.ค.': 'มีนาคม',
            'เม.ย.': 'เมษายน',
            'พ.ค.': 'พฤษภาคม',
            'มิ.ย.': 'มิถุนายน',
            'ก.ค.': 'กรกฎาคม',
            'ส.ค.': 'สิงหาคม',
            'ก.ย.': 'กันยายน',
            'ต.ค.': 'ตุลาคม',
            'พ.ย.': 'พฤศจิกายน',
            'ธ.ค.': 'ธันวาคม',
            'ทั้งหมด': 'ทั้งหมด'
        };

        document.addEventListener('DOMContentLoaded', () => {
            // Set default header to "ทั้งหมด"
            document.getElementById('selectedMonth').textContent = 'ทั้งหมด';
            document.getElementById('selectedYear').textContent = '';

            updateHeader(); // Update header on page load
        });

        document.getElementById('yearDropdown').addEventListener('change', updateHeader);
        document.getElementById('monthDropdown').addEventListener('change', updateHeader);

        function updateHeader() {
            const selectedYear = document.getElementById('yearDropdown').value || 'ทั้งหมด';
            const selectedMonth = document.getElementById('monthDropdown').value || 'ทั้งหมด';

            if (selectedYear === 'ทั้งหมด' && selectedMonth === 'ทั้งหมด') {
                document.getElementById('selectedMonth').textContent = 'ทั้งหมด';
                document.getElementById('selectedYear').textContent = '';
            } else if (selectedMonth === 'ทั้งหมด') {
                document.getElementById('selectedMonth').textContent = 'ทั้งหมด';
                document.getElementById('selectedYear').textContent = `พ.ศ. ${selectedYear}`;
            } else {
                document.getElementById('selectedMonth').textContent = monthMap[selectedMonth] || selectedMonth;
                document.getElementById('selectedYear').textContent = `พ.ศ. ${selectedYear}`;
            }
        }

        document.getElementById('yearDropdown').addEventListener('change', filterWorkRequests);
        document.getElementById('monthDropdown').addEventListener('change', filterWorkRequests);

        function filterWorkRequests() {
            const year = document.getElementById('yearDropdown').value || 'ทั้งหมด'; // ดึงค่าปีที่เลือก
            const month = document.getElementById('monthDropdown').value || 'ทั้งหมด'; // ดึงค่าเดือนที่เลือก

            // ดึงแถวทั้งหมดในตาราง
            const mainRows = document.querySelectorAll('tbody tr.main-row');
            let filteredCount = 0; // ตัวนับจำนวนแถวที่แสดง

            mainRows.forEach(mainRow => {
                const createdDateCell = mainRow.querySelector('td:nth-child(3)'); // เลือกคอลัมน์ "วันที่สร้าง"
                const createdDateText = createdDateCell ? createdDateCell.textContent.trim() : '';

                // เช็คว่าแถวตรงกับปีและเดือนที่เลือกหรือไม่
                const isYearMatch = year === 'ทั้งหมด' || createdDateText.includes(year);
                const isMonthMatch = month === 'ทั้งหมด' || createdDateText.includes(month);

                const shouldShowRow = isYearMatch && isMonthMatch;

                // แสดง/ซ่อนแถวหลัก
                mainRow.style.display = shouldShowRow ? '' : 'none';

                // แสดง/ซ่อนแถวที่เป็น task ที่เกี่ยวข้อง
                let next = mainRow.nextElementSibling;
                while (next && !next.classList.contains('main-row')) {
                    next.style.display = shouldShowRow ? '' : 'none';
                    next = next.nextElementSibling;
                }

                if (shouldShowRow) {
                    filteredCount++; // เพิ่มตัวนับเมื่อแถวหลักแสดง
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

            // อัปเดตจำนวนงานที่กรองแล้ว
            document.getElementById('totalWorkRequests').textContent = filteredCount; // แสดงจำนวนแถวที่แสดง
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Set default header to "ทั้งหมด"
            document.getElementById('selectedMonth').textContent = 'ทั้งหมด';
            document.getElementById('selectedYear').textContent = '';

            lockTableHeaderWidths(); // ล็อกหัวตารางไว้ตั้งแต่โหลด
        });

        function lockTableHeaderWidths() {
            const table = document.querySelector('table');
            const headerCells = table.querySelectorAll('thead th');

            headerCells.forEach((th) => {
                const width = th.offsetWidth;
                th.style.width = width + 'px'; // ล็อกความกว้างไว้
            });
        }
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('selectedMonth').textContent = 'ทั้งหมด';
            document.getElementById('selectedYear').textContent = '';

            setTimeout(() => {
                lockTableHeaderWidths();
            }, 0); // รอให้ DOM render ก่อนนิดนึง
        });
    </script>
@endsection
