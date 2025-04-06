@extends('layouts.employee_layouts')

@section('content')
    <div class="d-flex">
        <div class="content w-100">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-0">สถิติงาน</h3>
                <ul class="nav nav-tabs" id="taskTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#myTasks">รายงานของฉัน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#departmentTasks">รายงานขององค์กร</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <!-- 🔽 รายงานของฉัน -->
                <div class="tab-pane fade show active mt-3" id="myTasks">
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
                                    <div class="stats-number">10</div>
                                    <div class="stats-label">งานที่ได้รับทั้งหมด</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">6</div>
                                    <div class="stats-label">งานที่ทำเสร็จสิ้น</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">3</div>
                                    <div class="stats-label">งานที่ส่งล่าช้า</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">1</div>
                                    <div class="stats-label">งานที่ปฏิเสธ</div>
                                </div>
                            </div>
                        </div>

                        <!-- 🔽 กราฟวงกลม -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="chart-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="workChart" width="300" height="300"></canvas>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="legend-container">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(255, 99, 132, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานที่ทำเสร็จสิ้น</div>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(54, 192, 201, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานที่ส่งล่าช้า</div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(255, 159, 64, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานที่ปฏิเสธ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <div class="stats-number">88</div>
                                    <div class="stats-label">งานที่มอบหมาย</div>   <!--all ทำการมอบหมายงาน และ งานที่ถูกมอบหมาย-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">76</div>
                                    <div class="stats-label">งานที่เสร็จสิ้นทั้งหมด</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">7</div>
                                    <div class="stats-label">งานล่าช้า</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">5</div>
                                    <div class="stats-label">งานถูกปฏิเสธ</div>
                                </div>
                            </div>
                        </div>

                        <!-- 🔽 กราฟวงกลม -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="chart-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="orgPieChart" width="300" height="300"></canvas>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="legend-container">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(75, 192, 192, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานที่เสร็จสิ้นทั้งหมด</div>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(255, 206, 86, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานล่าช้า</div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(153, 102, 255, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานถูกปฏิเสธ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        }

        populateYearDropdown("yearDropdown");
        populateMonthDropdown("monthDropdown");
        populateYearDropdown("orgYearDropdown");
        populateMonthDropdown("orgMonthDropdown");
    </script>

    <!-- 🔽 โหลด Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- 🔽 สร้างกราฟวงกลม -->
    <script>
        window.onload = function() {
            // ✅ ฟังก์ชันสร้างกราฟวงกลม
            function drawPieChart(canvasId, labels, values, colors) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels, // ✅ ใช้ labels ที่แตกต่างกัน
                        datasets: [{
                            data: values,
                            backgroundColor: colors, // ✅ ใช้สีที่แตกต่างกัน
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true
                    }
                });
            }

            // ✅ กราฟวงกลมฝั่ง "รายงานของฉัน"
            const myLabels = ['งานที่ทำเสร็จสิ้น', 'งานที่ส่งล่าช้า', 'งานที่ปฏิเสธ'];
            const myStats = document.querySelectorAll('#myTasks .stats-number');
            const myValues = [
                parseFloat(myStats[1]?.textContent) || 0, // งานที่ทำเสร็จสิ้น
                parseFloat(myStats[2]?.textContent) || 0, // งานที่ส่งล่าช้า
                parseFloat(myStats[3]?.textContent) || 0  // งานที่ปฏิเสธ
            ];
            const myColors = [
                'rgba(255, 99, 132, 0.8)', // สีของงานที่ทำเสร็จสิ้น
                'rgba(54, 192, 201, 0.8)', // สีของงานที่ส่งล่าช้า
                'rgba(255, 159, 64, 0.8)'  // สีของงานที่ปฏิเสธ
            ];
            drawPieChart('workChart', myLabels, myValues, myColors);

            // ✅ กราฟวงกลมฝั่ง "รายงานขององค์กร"
            const orgLabels = ['งานที่เสร็จสิ้นทั้งหมด', 'งานล่าช้า', 'งานถูกปฏิเสธ'];
            const orgStats = document.querySelectorAll('#departmentTasks .stats-number');
            const orgValues = [
                parseFloat(orgStats[1]?.textContent) || 0, // งานที่เสร็จสิ้น
                parseFloat(orgStats[2]?.textContent) || 0, // งานล่าช้า
                parseFloat(orgStats[3]?.textContent) || 0  // งานถูกปฏิเสธ
            ];
            const orgColors = [
                'rgba(75, 192, 192, 0.8)', // สีของงานที่เสร็จสิ้นทัังหมด
                'rgba(255, 206, 86, 0.8)', // สีของงานล่าช้า
                'rgba(153, 102, 255, 0.8)'  // สีของงานถูกปฏิเสธ
            ];
            drawPieChart('orgPieChart', orgLabels, orgValues, orgColors);
        };
    </script>
@endsection
