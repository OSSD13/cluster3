{{--
sent_table.blade.php
Display form show table manage employee
@input : emp_id, emp_name, dept_id
@output : form show table manage employee
@author : Naphat Maneechansuk 66160099
@Create Date : 2025-03-25
--}}
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ตารางพนักงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200;300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('public\css\manage_employee.css') }}">
</head>
<body>
    <div class="container mt-4">
        <div class="row mb-3 d-flex align-items-center justify-content-between">
            <div class="col-md-6 d-flex align-items-center">
                <h2 class="mb-0 text-header">จัดการพนักงาน</h2>
            </div>
            <div class="col-md-4">
                <input type="text" id="searchInput" class="rounded-pill form-control shadow-lg bg-body rounded" placeholder="search">
            </div>
        </div>
        <table class="table table-hover">
            <thead class="table-secondary">
              <tr>
                <th class="col-2 text-center">รหัสพนักงาน</th>
                <th class="col-4 text-center">ชื่อ-นามสกุล</th>
                <th class="col-1 text-center"></th>
                <th class="col-3 text-center">เเผนก</th>
                <th class="col-2 text-center"></th>
              </tr>
            </thead>
            <tbody class="text-center">
              <tr>
                <th scope="row">0001</th>
                <td>Mark</td>
                <td></td>
                <td>ไอที</td>
                <td><a href="{{url('/b')}}"><i class="fa-solid fa-pen"></a></i></td>
              </tr>
              <tr>
                <th scope="row">0002</th>
                <td>Jacob</td>
                <td></td>
                <td>ทีไอ</td>
                <td><i class="fa-solid fa-pen"></i></td>
              </tr>
              <tr>
                <th scope="row">0003</th>
                <td>Larry the Bird</td>
                <td></td>
                <td>ทีทีไอไอ</td>
                <td><i class="fa-solid fa-pen"></i></td>
              </tr>
            </tbody>
          </table>
    </div>

    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#employeeTable tr");
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>
</body>
</html>
