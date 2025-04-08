{{--
* report_statistic.blade.php
* Display form show statistic report work request
* @input : workRequest, task
* @output : form show statistic report work request
* @input : wrs_tasks, wrs_departments, wrs_employees
* @output : statistic report work request(employee's pie chart ,organization's pie chart ,organization's bar chart)
* @author : Natthanan Sirisurayut 66160352
* @Create Date : 2025-04-06
* @Update Date : 2025-04-08
* @Update By : Supasit Meedecha 66160098
*
--}}

@extends('layouts.employee_layouts')

@section('content')
    <div class="d-flex">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0">สถิติงาน</h3>
                <ul class="nav nav-tabs" id="taskTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#myReport">รายงานของฉัน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#orgReport">รายงานขององค์กร</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <!-- 🔽 รายงานของฉัน -->
                <div class="tab-pane fade show active mt-3" id="myReport">
                    <div class="container py-4">
                        <!-- 🔽 Dropdown ปีและเดือน -->
                        <div class="d-flex justify-content-end align-items-center mb-4">
                            <div class="me-2">
                                <select id="yearDropdown" class="form-select"></select>
                            </div>
                            <div>
                                <select id="monthDropdown" class="form-select"></select>
                            </div>
                        </div>

                        <!-- 🔽 การ์ดสถิติงาน -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number total">{{ $statistics->total }}</div>
                                    <div class="stats-label">งานที่ได้รับทั้งหมด</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number completed">{{ $statistics->completed }}</div>
                                    <div class="stats-label">งานที่ทำเสร็จสิ้น</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number delayed">{{ $statistics->delayed }}</div>
                                    <div class="stats-label">งานที่ส่งล่าช้า</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number rejected">{{ $statistics->rejected }}</div>
                                    <div class="stats-label">งานที่ปฏิเสธ</div>
                                </div>
                            </div>
                        </div>

                        <!-- 🔽 กราฟวงกลม -->
                        <div class="row mt-4">
                            <div class="col-12 pie-container">
                                <div style="width: 400px; height: 400px;">
                                    <canvas id="workChart"></canvas>
                                </div>
                            </div>
                            <p class="text-center mt-2">กราฟวงกลมแสดงสถิติของฉัน</p>
                        </div>
                    </div>
                </div>

                <!-- 🔽 รายงานขององค์กร -->
                <div class="tab-pane fade mt-3" id="orgReport">
                    <div class="container py-4">
                        <!-- 🔽 Dropdown ปีและเดือน -->
                        <div class="d-flex justify-content-end align-items-center mb-4">
                            <div class="me-2">
                                <select id="orgYearDropdown" class="form-select"></select>
                            </div>
                            <div>
                                <select id="orgMonthDropdown" class="form-select"></select>
                            </div>
                        </div>

                        <!-- 🔽 การ์ดสถิติงาน -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number coTotal">{{ $coStatistics->total }}</div>
                                    <div class="stats-label">งานทั้งหมด</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number coCompleted">{{ $coStatistics->completed }}</div>
                                    <div class="stats-label">งานที่ทำเสร็จสิ้น</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number coDelayed">{{ $coStatistics->delayed }}</div>
                                    <div class="stats-label">งานที่ส่งล่าช้า</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number coRejected">{{ $coStatistics->rejected }}</div>
                                    <div class="stats-label">งานที่ปฏิเสธ</div>
                                </div>
                            </div>
                        </div>

                        <!-- 🔽 กราฟวงกลมและกราฟแท่ง -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="row">
                                    <!-- Pie Chart -->
                                    <div class="col-md-6 text-center">
                                        <div style="width: 400px; height: 400px; margin: auto;">
                                            <canvas id="orgPieChart"></canvas>
                                        </div>
                                        <p class="text-center mt-2">กราฟวงกลมแสดงสถิติขององค์กร</p>
                                    </div>
                                    <!-- Bar Chart -->
                                    <div class="col-md-6 text-center">
                                        <div style="width: 400px; height: 400px; margin: auto;">
                                            <canvas id="orgGroupedBarChart"></canvas>
                                        </div>
                                        <p class="text-center mt-2">กราฟแท่งแสดงสถิติขององค์กร</p>
                                    </div>
                                </div>
                            </div>
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
         * populateYearDropdown(selectId) , populateMonthDropdown(selectId)
         * Filter work requests based on selected year and month
         * @input : year, month
         * @output : Filtered work requests in statistics
         * @author : Supasit Meedecha 66160098
         * @Create Date : 2025-04-06
         * @Update Date : 2025-04-07
         */
        let cachedStatistics = null;
        let cachedCoStatistics = null;

        // 🔽 เติม Dropdown ปี
        function populateYearDropdown(selectId) {
            const select = document.getElementById(selectId);
            const currentYear = new Date().getFullYear();
            for (let i = 0; i < 10; i++) {
                const year = currentYear - i;
                const option = document.createElement("option");
                option.value = year + 543;
                option.textContent = year + 543;
                if (year === currentYear) {
                    option.selected = true; // ตั้งค่า default เป็นปีปัจจุบัน
                }
                select.appendChild(option);
            }
        }

        // 🔽 เติม Dropdown เดือน
        function populateMonthDropdown(selectId) {
            const select = document.getElementById(selectId);
            const months = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.",
                "ธ.ค."
            ];
            const currentMonth = new Date().getMonth(); // เดือนปัจจุบัน (0-based index)
            months.forEach((month, index) => {
                const option = document.createElement("option");
                option.value = index + 1;
                option.textContent = month;
                if (index === currentMonth) {
                    option.selected = true; // ตั้งค่า default เป็นเดือนปัจจุบัน
                }
                select.appendChild(option);
            });
            const allOption = document.createElement("option");
            allOption.value = "all";
            allOption.textContent = "ทั้งปี";
            select.appendChild(allOption);
        }

        // 🔽 ดึงข้อมูลสถิติจากเซิร์ฟเวอร์ (รวม "รายงานของฉัน" และ "รายงานขององค์กร")
        async function fetchStatisticsData(year, month) {
            const url = "{{ route('report.statistics') }}";
            const params = new URLSearchParams({
                year,
                month
            });

            if (cachedStatistics && cachedStatistics.year === year && cachedStatistics.month === month) {
                return cachedStatistics.data;
            }

            const response = await fetch(`${url}?${params}`);
            const data = await response.json();
            cachedStatistics = {
                year,
                month,
                data
            };
            return data;
        }

        // 🔽 ดึงข้อมูลสถิติขององค์กรจากเซิร์ฟเวอร์
        async function fetchCoStatisticsData(year, month) {
            const url = "{{ route('report.coStatistics') }}";
            const params = new URLSearchParams({
                year,
                month
            });

            if (cachedCoStatistics && cachedCoStatistics.year === year && cachedCoStatistics.month === month) {
                return cachedCoStatistics.data;
            }

            const response = await fetch(`${url}?${params}`);
            const data = await response.json();
            cachedCoStatistics = {
                year,
                month,
                data
            };
            return data;
        }
        async function fetchDepartmentTaskStatistics(year, month) {
            const url = "{{ route('department.taskStatistics') }}";
            const params = new URLSearchParams({
                year,
                month
            });

            const response = await fetch(`${url}?${params}`);
            const data = await response.json();

            // เตรียมข้อมูลสำหรับกราฟแท่ง
            const labels = data.labels; // ชื่อแผนก
            const datasets = data.datasets; // ข้อมูลของแต่ละแผนก

            // อัปเดตกราฟแท่ง
            drawGroupedBarChart('orgGroupedBarChart', labels, datasets);
        }

        // 🔽 อัปเดตการ์ดสถิติ
        function updateStatisticsCards(data) {
            document.querySelector('.stats-number.total').textContent = data.total;
            document.querySelector('.stats-number.completed').textContent = data.completed;
            document.querySelector('.stats-number.delayed').textContent = data.delayed;
            document.querySelector('.stats-number.rejected').textContent = data.rejected;
        }

        // 🔽 อัปเดตการ์ดสถิติขององค์กร
        function updateCoStatisticsCards(data) {
            document.querySelector('.stats-number.coTotal').textContent = data.total;
            document.querySelector('.stats-number.coCompleted').textContent = data.completed;
            document.querySelector('.stats-number.coDelayed').textContent = data.delayed;
            document.querySelector('.stats-number.coRejected').textContent = data.rejected;
        }

        // 🔽 สร้างกราฟวงกลม
        function drawPieChart(canvasId, labels, values, colors) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            if (window.myChart) {
                window.myChart.destroy();
            }
            window.myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    family: 'Sarabun', // เปลี่ยนฟอนต์เป็น Sarabun
                                }
                            }
                        }
                    }
                }
            });
        }

        function drawGroupedBarChart(canvasId, labels, datasets) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext("2d");

            // ลบกราฟเก่าออกก่อน
            if (canvas.chartInstance) {
                canvas.chartInstance.destroy();
            }

    // สร้างกราฟใหม่
    canvas.chartInstance = new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: datasets,
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom",
                },
            },
            scales: {
                x: {
                    beginAtZero: true,
                },
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
}


        // 🔽 โหลดข้อมูลเมื่อเปลี่ยนแท็บ
        async function handleTabChange(targetTab, year, month) {
            if (targetTab === '#myReport') {
                const data = await fetchStatisticsData(year, month);
                updateStatisticsCards(data);

                // อัปเดตกราฟวงกลม
                const labels = ['งานที่ทำเสร็จสิ้น', 'งานที่ส่งล่าช้า', 'งานที่ปฏิเสธ'];
                const values = [data.completed, data.delayed, data.rejected];
                const colors = ['rgba(255, 99, 132, 0.8)', 'rgba(54, 192, 201, 0.8)', 'rgba(255, 159, 64, 0.8)'];
                drawPieChart('workChart', labels, values, colors);
            } else if (targetTab === '#orgReport') {
                const data = await fetchCoStatisticsData(year, month);
                updateCoStatisticsCards(data);

                // อัปเดตกราฟวงกลม
                const labels = ['งานที่ทำเสร็จสิ้น', 'งานที่ส่งล่าช้า', 'งานที่ปฏิเสธ'];
                const values = [data.completed, data.delayed, data.rejected];
                const colors = ['rgba(255, 99, 132, 0.8)', 'rgba(54, 192, 201, 0.8)', 'rgba(255, 159, 64, 0.8)'];
                drawPieChart('orgPieChart', labels, values, colors);
            }
        }

        // 🔽 เริ่มต้นเมื่อโหลดหน้า
        document.addEventListener('DOMContentLoaded', () => {
            populateYearDropdown("yearDropdown");
            populateMonthDropdown("monthDropdown");
            populateYearDropdown("orgYearDropdown");
            populateMonthDropdown("orgMonthDropdown");

            const yearDropdown = document.getElementById("yearDropdown");
            const monthDropdown = document.getElementById("monthDropdown");
            const orgYearDropdown = document.getElementById("orgYearDropdown");
            const orgMonthDropdown = document.getElementById("orgMonthDropdown");

            // โหลดข้อมูลเริ่มต้นสำหรับ "รายงานของฉัน"
            handleTabChange('#myReport', yearDropdown.value, monthDropdown.value);

            // Event Listener สำหรับการเปลี่ยนแท็บ
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('click', (event) => {
                    const targetTab = event.target.getAttribute('href');
                    const year = targetTab === '#myReport' ? yearDropdown.value : orgYearDropdown
                        .value;
                    const month = targetTab === '#myReport' ? monthDropdown.value : orgMonthDropdown
                        .value;
                    handleTabChange(targetTab, year, month);
                });
            });

            // Event Listener สำหรับการเปลี่ยนปีและเดือน
            yearDropdown.addEventListener('change', () => {
                handleTabChange('#myReport', yearDropdown.value, monthDropdown.value);
            });

            monthDropdown.addEventListener('change', () => {
                handleTabChange('#myReport', yearDropdown.value, monthDropdown.value);
            });

            orgYearDropdown.addEventListener('change', () => {
                handleTabChange('#orgReport', orgYearDropdown.value, orgMonthDropdown.value);
            });

            orgMonthDropdown.addEventListener('change', () => {
                handleTabChange('#orgReport', orgYearDropdown.value, orgMonthDropdown.value);
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const orgYearDropdown = document.getElementById("orgYearDropdown");
            const orgMonthDropdown = document.getElementById("orgMonthDropdown");

            orgYearDropdown.addEventListener('change', () => {
                fetchDepartmentTaskStatistics(orgYearDropdown.value, orgMonthDropdown.value);
            });

            orgMonthDropdown.addEventListener('change', () => {
                fetchDepartmentTaskStatistics(orgYearDropdown.value, orgMonthDropdown.value);
            });

            // โหลดข้อมูลเริ่มต้น
            fetchDepartmentTaskStatistics(orgYearDropdown.value, orgMonthDropdown.value);
        });
    </script>
@endsection
