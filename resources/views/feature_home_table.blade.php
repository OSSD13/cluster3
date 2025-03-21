
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WRS - Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { font-family: 'Arial', sans-serif; }
        .sidebar { width: 250px; background: #f8f9fa; height: 100vh; position: fixed; padding: 20px; }
        .content { margin-left: 270px; padding: 20px; }
        .nav-link.active { background-color: #007bff !important; color: white !important; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h4 class="text-primary">📄 WRS</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link active" href="#">หน้าหลัก</a></li>
                <li class="nav-item"><a class="nav-link" href="#">สร้างใบสั่งงาน</a></li>
                <li class="nav-item"><a class="nav-link" href="#">แบบร่าง</a></li>
                <li class="nav-item"><a class="nav-link" href="#">ส่งแล้ว</a></li>
                <li class="nav-item"><a class="nav-link" href="#">จัดเก็บ</a></li>
                <li class="nav-item"><a class="nav-link" href="#">รายงาน</a></li>
            </ul>
        </div>
        <div class="content w-100">
            <h3>รายการงาน</h3>
            <ul class="nav nav-tabs" id="taskTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#received">งานที่ได้รับ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#inprogress">กำลังดำเนินการ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#completed">เสร็จสิ้น</a>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="received">
                    <p>แสดงรายการงานที่ได้รับ</p>
                </div>
                <div class="tab-pane fade" id="inprogress">
                    <p>แสดงรายการงานที่กำลังดำเนินการ</p>
                </div>
                <div class="tab-pane fade" id="completed">
                    <p>แสดงรายการงานที่เสร็จสิ้น</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
