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
                        <a class="nav-link" data-bs-toggle="tab" href="#departmentTasks">รายงานขององค์กร</a>
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
                <div class="tab-pane fade mt-3" id="departmentTasks">
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
    <!-- 🔽 Script เติมปีและเดือน -->
    <script>
        function populateYearDropdown(selectId) {
            const select = document.getElementById(selectId);
            const currentYear = new Date().getFullYear();
            for (let i = 0; i < 10; i++) {
                const year = currentYear - i;
                const option = document.createElement("option");
                option.value = year;
                option.textContent = year;
                select.appendChild(option);
            }
        }

        function populateMonthDropdown(selectId) {
            const select = document.getElementById(selectId);
            const months = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.",
                "ธ.ค.", "ทั้งปี"
            ];
            months.forEach((month, index) => {
                const option = document.createElement("option");
                option.value = index + 1;
                option.textContent = month;
                select.appendChild(option);
            });
            const allOption = document.createElement("option");
            allOption.value = "all";
            allOption.textContent = "ทั้งปี";
            select.appendChild(allOption);
        }

        function fetchStatistics(year, month) {
            const url = "{{ route('report.statistics') }}";
            const params = new URLSearchParams({ year, month });

            fetch(`${url}?${params}`)
                .then(response => response.json())
                .then(data => {
                    // อัปเดตการ์ดสถิติ
                    document.querySelector('.stats-number.total').textContent = data.total;
                    document.querySelector('.stats-number.completed').textContent = data.completed;
                    document.querySelector('.stats-number.delayed').textContent = data.delayed;
                    document.querySelector('.stats-number.rejected').textContent = data.rejected;

                    // อัปเดตกราฟวงกลม
                    updatePieChart('workChart', [data.completed, data.delayed, data.rejected]);
                });
        }

        function updatePieChart(canvasId, values) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['งานที่ทำเสร็จสิ้น', 'งานที่ส่งล่าช้า', 'งานที่ปฏิเสธ'],
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 192, 201, 0.8)',
                            'rgba(255, 159, 64, 0.8)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            populateYearDropdown("yearDropdown");
            populateMonthDropdown("monthDropdown");

            const yearDropdown = document.getElementById("yearDropdown");
            const monthDropdown = document.getElementById("monthDropdown");

            yearDropdown.addEventListener('change', () => {
                fetchStatistics(yearDropdown.value, monthDropdown.value);
            });

            monthDropdown.addEventListener('change', () => {
                fetchStatistics(yearDropdown.value, monthDropdown.value);
            });

            // โหลดข้อมูลเริ่มต้น
            fetchStatistics(yearDropdown.value, monthDropdown.value);
        });

        // ✅ ฟังก์ชันสร้างกราฟวงกลม
        function drawPieChart(canvasId, labels, values, colors) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
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
                    maintainAspectRatio: false, // ปิดการรักษาอัตราส่วน
                    plugins: {
                        legend: {
                            position: 'right', // แสดง legend ทางด้านขวา
                            labels: {
                                usePointStyle: true, // ใช้จุดแทนสี่เหลี่ยม
                                pointStyle: 'circle' // รูปแบบจุดเป็นวงกลม
                            }
                        }
                    }
                }
            });
        }

        // ✅ กราฟวงกลมฝั่ง "รายงานของฉัน"
        const myLabels = ['งานที่ทำเสร็จสิ้น', 'งานที่ส่งล่าช้า', 'งานที่ปฏิเสธ'];
        const myStats = document.querySelectorAll('#myReport .stats-number');
        const myValues = [
            parseFloat(myStats[1]?.textContent) || 0, // งานที่ทำเสร็จสิ้น
            parseFloat(myStats[2]?.textContent) || 0, // งานที่ส่งล่าช้า
            parseFloat(myStats[3]?.textContent) || 0 // งานที่ปฏิเสธ
        ];
        const myColors = [
            'rgba(255, 99, 132, 0.8)', // สีของงานที่ทำเสร็จสิ้น
            'rgba(54, 192, 201, 0.8)', // สีของงานที่ส่งล่าช้า
            'rgba(255, 159, 64, 0.8)' // สีของงานที่ปฏิเสธ
        ];
        drawPieChart('workChart', myLabels, myValues, myColors);

        // ✅ กราฟวงกลมฝั่ง "รายงานขององค์กร"
        const orgLabels = ['งานที่เสร็จสิ้นทั้งหมด', 'งานล่าช้า', 'งานถูกปฏิเสธ'];
        const orgStats = document.querySelectorAll('#departmentTasks .stats-number');
        const orgValues = [
            parseFloat(orgStats[1]?.textContent) || 0, // งานที่เสร็จสิ้น
            parseFloat(orgStats[2]?.textContent) || 0, // งานล่าช้า
            parseFloat(orgStats[3]?.textContent) || 0 // งานถูกปฏิเสธ
        ];
        const orgColors = [
            'rgba(75, 192, 192, 0.8)', // สีของงานที่เสร็จสิ้นทัังหมด
            'rgba(255, 206, 86, 0.8)', // สีของงานล่าช้า
            'rgba(153, 102, 255, 0.8)' // สีของงานถูกปฏิเสธ
        ];

        drawPieChart('orgPieChart', orgLabels, orgValues, orgColors);
        // ✅ ฟังก์ชันสร้างกราฟแท่งแบบกลุ่ม
        function drawGroupedBarChart(canvasId, labels, datasets) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            ctx.canvas.width = 500; // กำหนดความกว้าง
            ctx.canvas.height = 500; // กำหนดความสูง
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels, // ชื่อแผนก เช่น ["ไอจี", "ไอที", "ไอวี"]
                    datasets: datasets // ข้อมูลของแต่ละกลุ่ม
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Disable aspect ratio
                    plugins: {
                        legend: {
                            position: 'top' // แสดง legend ด้านบน
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // ✅ ข้อมูลสำหรับ Bar Chart
        const departmentLabels = ['ไอจี', 'ไอที', 'ไอวี']; // ชื่อแผนก
        const departmentDatasets = [{
                label: 'งานที่เสร็จสิ้นทั้งหมด',
                data: [20, 40, 30], // ข้อมูลของแต่ละแผนก
                backgroundColor: 'rgba(75, 192, 192, 0.8)' // สีของงานที่เสร็จสิ้นทั้งหมด
            },
            {
                label: 'งานล่าช้า',
                data: [10, 15, 5], // ข้อมูลของแต่ละแผนก
                backgroundColor: 'rgba(255, 206, 86, 0.8)' // สีของงานล่าช้า
            },
            {
                label: 'งานถูกปฏิเสธ',
                data: [5, 8, 2], // ข้อมูลของแต่ละแผนก
                backgroundColor: 'rgba(153, 102, 255, 0.8)' // สีของงานถูกปฏิเสธ
            }
        ];

        // ✅ เรียกใช้ฟังก์ชันสร้าง Bar Chart
        drawGroupedBarChart('orgGroupedBarChart', departmentLabels, departmentDatasets);
    </script>
@endsection
