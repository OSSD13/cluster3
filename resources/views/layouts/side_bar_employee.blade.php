{{-- 
* side_bar_employee.blade.php
* sidebar_for_employee
* @input : -
* @output : 
* @author : Sarocha Dokyeesun
* @Create Date : 2025-03-18
--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('public/css/components/side_bar.css')}}">
    <title>Document</title>
</head>

<body>
    <div class="d-flex vh-100">
        <!-- Sidebar -->
        <aside class="sidebar bg-white shadow p-3 position-fixed vh-100" style="width: 250px;">
            <br><br><br><br>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link rounded p-3 sidebar-link {{ Route::currentRouteName() == 'main-page' ? 'active' : '' }}"
                        href="{{ url('/main') }}">
                        <i class="fa-solid fa-house me-2"></i> หน้าหลัก
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded p-3 sidebar-link {{ Route::currentRouteName() == 'form.index' ? 'active' : '' }}"
                        href="{{ route('form.index') }}">
                        <i class="fa-solid fa-folder-plus me-2"></i> สร้างใบสั่งงาน
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded p-3 sidebar-link {{ Route::currentRouteName() == 'draft' ? 'active' : '' }}"
                        href="#">
                        <i class="fa-solid fa-file-pen me-2"></i> แบบร่าง
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded p-3 sidebar-link {{ in_array(Route::currentRouteName(), ['sent', 'sent_detail']) ? 'active' : '' }}" href="{{ route('sent') }}">
                        <i class="fa-solid fa-upload me-2"></i> ส่งแล้ว
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded p-3 sidebar-link {{ Route::currentRouteName() == 'achrive' ? 'active' : '' }}"
                        href="#">
                        <i class="fa-solid fa-box-archive me-2"></i> จัดเก็บ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded p-3 sidebar-link justify-content-between {{ in_array(Route::currentRouteName(), ['report-stat', 'report-data']) ? 'active' : '' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#reportMenu" aria-expanded="false"
                        aria-controls="reportMenu">
                        <div>
                            <i class="fa-solid fa-chart-line me-1"></i> รายงาน
                        </div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <div class="collapse" id="reportMenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="sidebar-sub-link rounded p-3 {{ Route::currentRouteName() == 'report-stat' ? 'active' : '' }}"
                                    href="#" style="">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <i class="icon-sub fa-solid fa-chart-pie me-2"></i> รายงานสถิติงาน
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="sidebar-sub-link rounded p-3 {{ Route::currentRouteName() == 'report-data' ? 'active' : '' }} "
                                    href="#" style="">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <i class="icon-sub fa-solid fa-table-list me-2"></i> รายงานข้อมูล
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </aside>
</body>

</html>


<script>
    function setActive(element) {
        // ลบ 'active' ออกจากทุกลิงก์
        document.querySelectorAll('.sidebar-link').forEach((link) => {
            link.classList.remove('active');
        });

        function setActiveSubtask(element) {
            // ลบ 'active' ออกจากทุกลิงก์
            document.querySelectorAll('.sidebar-sub-link').forEach((link) => {
                link.classList.remove('active');
            });
            // เพิ่ม 'active' ลิงก์ที่คลิก
            element.classList.add('active', '#A9A8F5');
        }

        document.addEventListener("DOMContentLoaded", function() {
            // ดึง URL ปัจจุบัน
            const currentPath = window.location.pathname;

            // กำหนดค่า Active ตาม URL
            document.querySelectorAll('.sidebar-link').forEach((link) => {
                if (link.getAttribute("href") === currentPath) {
                    link.classList.add('active'); // เพิ่ม active class
                }
            });
        });
</script>
