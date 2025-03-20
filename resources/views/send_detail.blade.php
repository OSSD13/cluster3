<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายการงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .badge-status {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 0.9em;
        }
        .status-done { background-color: #28a745; color: white; }
        .status-pending { background-color: #ffc107; color: black; }
        .status-waiting { background-color: #6c757d; color: white; }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-white">
            <h5>รายละเอียดงาน</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">ชื่องานหลัก</label>
                <input type="text" class="form-control" value="ทำระบบให้จองห้องพัก" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">คำอธิบาย</label>
                <textarea class="form-control" rows="3" readonly>-</textarea>
            </div>

            <!-- งานย่อย -->
            <div class="accordion" id="taskAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            งานย่อย 1 <span class="ms-2 badge bg-success">เสร็จสิ้น</span>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#taskAccordion">
                        <div class="accordion-body">
                            ไม่มีรายละเอียดเพิ่มเติม
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            งานย่อย 2 <span class="ms-2 badge bg-warning">กำลังดำเนินการ</span>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#taskAccordion">
                        <div class="accordion-body">
                            <div class="mb-2">
                                <label class="form-label fw-bold">ผู้รับผิดชอบ</label>
                                <input type="text" class="form-control" value="แมค" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold">กำหนดส่ง</label>
                                <input type="text" class="form-control" value="13/03/2568" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-bold">ความสำคัญ</label>
                                <input type="text" class="form-control" value="สูง" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            งานย่อย 3 <span class="ms-2 badge bg-secondary">รอเริ่มงาน</span>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#taskAccordion">
                        <div class="accordion-body">
                            ไม่มีรายละเอียดเพิ่มเติม
                        </div>
                    </div>
                </div>
            </div>
            <!-- จบงานย่อย -->
        </div>
    </div>
</div>

</body>
</html>
