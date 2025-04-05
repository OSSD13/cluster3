@extends('layouts.employee_layouts')

@section('content')
    <style>
        th {
            color: #989BA4 !important;
        }

        h3 {
            font-family: 'TH Sarabun New', sans-serif !important;
            font-weight: bold;
            font-size: 36px;
            color: #4B49AC;
        }

        .custom-btn.active {
            background: none;
            border: none;
            font-size: 18px;
            font-weight: bold;
            color: #4B49AC;
            text-decoration: underline;
            text-decoration-thickness: 3px;
            /* ความหนาของเส้นใต้ */
            text-underline-offset: 4px;
            /* ระยะห่างจากตัวอักษร */
            outline: none;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            margin-left: 20px;
            cursor: pointer;
        }

        .custom-btn {
            background: none;
            border: none;
            font-size: 18px;
            font-weight: bold;
            color: #6c757d;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            margin-left: 20px;
            cursor: pointer;
            text-decoration: none;
            /* ลบเส้นใต้ */
        }

        .custom-btn:active,
        .custom-btn:focus {
            color: #4B49AC;
            text-decoration: underline;
            text-decoration-thickness: 3px;
            /* ความหนาของเส้นใต้ */
            text-underline-offset: 4px;
            /* ระยะห่างจากตัวอักษร */
            outline: none;
        }

        .nav-tabs {
            border-bottom: none;
        }

        .nav-tabs .nav-link {
            font-size: 18px;
            font-weight: bold;
            color: #6c757d;
            padding: 10px 20px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
        }

        .nav-tabs .nav-link.active {
            background-color: #4B49AC;
            color: white;
            border: none;
        }

        .tab-content {
            border: 1px solid #ddd;
            border-radius: 0 0 8px 8px;
            padding: 0px;
            background: white;
        }

        .custom-box {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        .stats-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            background-color: white;
            margin-bottom: 20px;
        }

        .stats-number {
            font-size: 36px;
            font-weight: bold;
        }

        .stats-label {
            font-size: 14px;
            color: #666;
        }

        .chart-container {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: white;
        }

        .nav-pills .nav-link.active {
            background-color: #5549bd;
        }

        .nav-pills .nav-link {
            color: #333;
        }
    </style>
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
                <div class="tab-pane fade show active mt-3" id="myTasks">
                    <div class="container py-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">

                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">0</div>
                                    <div class="stats-label">งานทั้งหมด</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">0</div>
                                    <div class="stats-label">งานเสร็จสิ้น</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">0</div>
                                    <div class="stats-label">งานล่าช้า</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-number">0</div>
                                    <div class="stats-label">งานถูกปฏิเสธ</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="chart-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="workChart" width="400" height="400"></canvas>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="legend-container">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(116, 96, 238, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานทั้งหมด (74.91)</div>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(255, 99, 132, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานเสร็จสิ้น (68.77)</div>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(54, 192, 201, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานล่าช้า (69.4)</div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        style="width: 12px; height: 12px; background-color: rgba(255, 159, 64, 0.8); border-radius: 50%; margin-right: 8px;">
                                                    </div>
                                                    <div>งานถูกปฏิเสธ (40.54)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade mt-3" id="departmentTasks">

                </div>
            </div>
        </div>
    </div>
@endsection
