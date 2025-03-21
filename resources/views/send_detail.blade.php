
@extends('layouts.employee_layouts')
@section('content')
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .back-button {
            display: flex;
            align-items: center;
            color: #666;
            text-decoration: none;
        }
        .page-title {
            font-size: 18px;
            margin: 0;
            color: #333;
        }
        .btn-primary {
            background-color: #5851c2;
            border-color: #5851c2;
        }
        .btn-outline-primary {
            color: #5851c2;
            border-color: #5851c2;
        }
        .btn-outline-primary:hover {
            background-color: #5851c2;
            color: white;
        }
        .task-details {
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 10px;
            display: none;
        }
        .table thead th {
            background-color: #f5f5f5;
            color: #666;
            font-weight: normal;
        }
        .profile-circle {
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        .dropdown-selector {
            margin-bottom: 15px;
        }
        .task-row {
            cursor: pointer;
        }
    </style>
<body>
    <div class="container mt-4">
        <div class="header">
            <h1 class="fw-bold">รายการงาน</h1>
            <div>
                <button class="btn btn-outline-primary me-2">ใบงานของฉัน</button>
                <button class="btn btn-primary">ใบงานของแผนก</button>
            </div>
        </div>

        <div class="mb-3">
            <a href="#" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                <span class="ms-2">รายละเอียดใบงานทั้งหมด</span>
            </a>
        </div>

        <div class="dropdown-selector">
            <select class="form-select" id="taskType">
                <option value="my">ใบงานของฉัน</option>
                <option value="department">ใบงานของแผนก</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 10%">ลำดับงาน</th>
                        <th style="width: 60%">ชื่องาน</th>
                        <th style="width: 30%">ผู้รับมอบหมาย</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="task-row" data-bs-toggle="collapse" data-bs-target="#details1">
                        <td class="text-center">1</td>
                        <td>จัดเก็บข้อมูล</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="profile-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                    </svg>
                                </div>
                                <span>นายอภิชาติ จิตภพ</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="details1">
                        <td colspan="3">
                            <div class="task-details">
                                <h5>รายละเอียดงาน:</h5>
                                <p>จัดเก็บข้อมูลประจำเดือน มีนาคม 2025 โดยแยกตามประเภทของข้อมูล</p>
                                <p>กำหนดส่ง: 25 มีนาคม 2025</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="task-row" data-bs-toggle="collapse" data-bs-target="#details2">
                        <td class="text-center">2</td>
                        <td>ตั้งค่าระบบและแผนซ่อมบำรุงอุปกรณ์เน็ต</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="profile-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                    </svg>
                                </div>
                                <span>นายอภิชิต ชินวัตร</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="details2">
                        <td colspan="3">
                            <div class="task-details">
                                <h5>รายละเอียดงาน:</h5>
                                <p>ตั้งค่าระบบและจัดทำแผนการซ่อมบำรุงอุปกรณ์เครือข่ายประจำไตรมาส</p>
                                <p>กำหนดส่ง: 30 มีนาคม 2025</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="task-row" data-bs-toggle="collapse" data-bs-target="#details3">
                        <td class="text-center">3</td>
                        <td>จำแนกสถิติผู้มาใช้บริการ</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="profile-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                    </svg>
                                </div>
                                <span>นางสาวปาริชาติ ปุ้ม</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="details3">
                        <td colspan="3">
                            <div class="task-details">
                                <h5>รายละเอียดงาน:</h5>
                                <p>จำแนกสถิติผู้มาใช้บริการตามช่วงเวลาและประเภทของการให้บริการ</p>
                                <p>กำหนดส่ง: 20 มีนาคม 2025</p>
                            </div>
                        </td>
                    </tr>

                    <tr class="task-row" data-bs-toggle="collapse" data-bs-target="#details4">
                        <td class="text-center">4</td>
                        <td>สร้างฟอร์ม "แบบสอบถาม" สำหรับแผนกพนักงานใหม่บริษัท</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="profile-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-person" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                    </svg>
                                </div>
                                <span>นายกิตติพร</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse" id="details4">
                        <td colspan="3">
                            <div class="task-details">
                                <h5>รายละเอียดงาน:</h5>
                                <p>สร้างแบบฟอร์มสำหรับเก็บข้อมูลความคิดเห็นของพนักงานใหม่ต่อกระบวนการปฐมนิเทศ</p>
                                <p>กำหนดส่ง: 15 มีนาคม 2025</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show task details on click
            const taskRows = document.querySelectorAll('.task-row');
            taskRows.forEach(row => {
                row.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-bs-target');
                    const detailsRow = document.querySelector(targetId);
                    
                    if (detailsRow.classList.contains('show')) {
                        // If already expanded, just toggle
                        return;
                    }
                    
                    // Make sure all details elements are displayed when expanded
                    const detailsElement = detailsRow.querySelector('.task-details');
                    detailsElement.style.display = 'block';
                });
            });

            // Handle task type selection
            document.getElementById('taskType').addEventListener('change', function() {
                const buttons = document.querySelectorAll('.header button');
                if (this.value === 'my') {
                    buttons[0].classList.remove('btn-outline-primary');
                    buttons[0].classList.add('btn-primary');
                    buttons[1].classList.remove('btn-primary');
                    buttons[1].classList.add('btn-outline-primary');
                } else {
                    buttons[0].classList.remove('btn-primary');
                    buttons[0].classList.add('btn-outline-primary');
                    buttons[1].classList.remove('btn-outline-primary');
                    buttons[1].classList.add('btn-primary');
                }
            });

            // Sync button selection with dropdown
            document.querySelectorAll('.header button').forEach((button, index) => {
                button.addEventListener('click', function() {
                    document.getElementById('taskType').value = index === 0 ? 'my' : 'department';
                    
                    // Update button styles
                    document.querySelectorAll('.header button').forEach(btn => {
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-outline-primary');
                    });
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-primary');
                });
            });
        });
    </script>
</body>
</html>

@endsection