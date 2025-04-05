{{--
* side_bar_admin.blade.php
* sidebar_for_admin
* @input : -
* @output :
* @author : Sarocha Dokyeesun
* @Create Date : 2025-03-17
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="public/css/components/side_bar.css">
    <title>Document</title>
</head>

<body>
    <div class="d-flex vh-100">
        <!-- Sidebar -->
    <aside class="sidebar bg-white shadow p-3 position-fixed vh-100" style="width: 250px;">
        <br><br><br><br>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link rounded p-3 sidebar-link {{ Route::currentRouteName() == 'manage-emp' ? 'active' : ''}}" href="{{ url('/manage_department') }}">
                        <i class="fa-solid fa-user-tie me-2"></i> จัดการพนักงาน
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded p-3 sidebar-link {{ Route::currentRouteName() == 'manage-department' ? 'active' : ''}}" href="{{ url('/manage_department') }}">
                        <i class="fa-solid fa-building me-2"></i> จัดการแผนก
                    </a>
                </li>
            </ul>
        </aside>
</body>

</html>


<script>

</script>
