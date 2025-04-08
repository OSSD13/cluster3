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
    <link rel="stylesheet" href="public/css/components/header.css">
    <title>Document</title>
</head>

<body>
    <header class="d-flex align-items-center shadow-sm bg-white px-4 position-fixed w-100" style="height: 80px; z-index: 1050;">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        {{-- โลโก้ --}}
        <div class="logo">
            <h5 class="text-primary fw-bold "><img style="width: 180px; height: 100px;"
                                src="{{ asset('/public/image/logo.png') }}" alt="Website Logo"> </h5>
        </div>

        {{-- โปรไฟล์  --}} 
        <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#" id="profileDropdown"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="" alt="Profile Picture" class="rounded-circle"
                    style="width: 40px; height: 40px; object-fit: cover;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="profileDropdown"
                style="border-radius: 12px;">
                <li>
                    {{-- href="{{ route('logout') }} ยังไม่มี route --}}
                    <a class="dropdown-item text-danger d-flex align-items-center"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-power-off me-2"></i> ออกจากระบบ
                    </a>
                </li>
                {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form> --}}
            </ul>
        </div>
    </div>
</header>
</body>
</html>