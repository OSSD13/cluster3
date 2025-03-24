<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายการงาน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200;300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public\css\sent_table.css') }}">
</head>
<body>
<div class="container mt-4">
    <div class="row mb-3 d-flex align-items-center justify-content-between">
        <div class="col-md-6 d-flex align-items-center">
            <h2 class="mb-0 text-header"><u>รายการงาน</u></h2>
        </div>
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search">
        </div>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="col-3 ">ชื่อในงาน</th>
                <th class="col-3 ">ชื่องาน</th>
                <th class="col-2 text-center">สถานะ</th>
                <th class="col-2 text-center">ความสำคัญ</th>
                <th class="col-2 text-center">กำหนดส่ง</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>โปรเจกท์ท่องเที่ยว</td>
                <td>ทำคู่มือ</td>
                <td class="text-center"><span class="status success">เสร็จสิ้น</span></td>
                <td class="text-center"><span class="importance danger ">สูง</span></td>
                <td class="text-center">พรุ่งนี้ 23:59</td>
            </tr>
            <tr>
                <td>เดินทางไปตรวจพื้นที่</td>
                <td>สำรวจผลกระทบ</td>
                <td class="text-center"><span class="status success">เสร็จสิ้น</span></td>
                <td class="text-center"><span class="importance danger">สูง</span></td>
                <td class="text-center">พรุ่งนี้ 23:59</td>
            </tr>
            <tr>
                <td>ระบบใบสั่งงาน</td>
                <td>ทำเอกสารประชุม</td>
                <td class="text-center"><span class="status warning">กำลังดำเนินการ</span></td>
                <td class="text-center"><span class="importance danger">สูง</span></td>
                <td class="text-center">1 มี.ค. 25 23:59</td>
            </tr>
            <tr>
                <td>สร้างโลก</td>
                <td>ปลูกต้นไม้ 100 ต้น</td>
                <td class="text-center"><span class="status warning">กำลังดำเนินการ</span></td>
                <td class="text-center"><span class="importance warning">กลาง</span></td>
                <td class="text-center">3 มี.ค. 25 23:59</td>
            </tr>
            <tr>
                <td>สายพีอาร์จัด</td>
                <td>สร้างบทสัมภาษณ์</td>
                <td class="text-center"><span class="status info">รอตรวจสอบ</span></td>
                <td class="text-center"><span class="importance success">ต่ำ</span></td>
                <td class="text-center">4 มี.ค. 25 23:59</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("tbody tr");
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

</body>
</html>
