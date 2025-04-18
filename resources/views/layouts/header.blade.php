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
    <link rel="stylesheet" href="{{ asset('public/css/components/header.css')}}">
    <title>Document</title>
    <style>
        .logout-title {
            color: #4B49AC;
        }

        .custom-cancel {
            background-color: #D14B4B;
            color: white;
            font-weight: 350;
            border: none;
            padding: 8px 24px;
            border-radius: 12px;
            font-size: 1rem;
            width: 130px;
        }

        .custom-logout {
            background-color: #4B49AC;
            color: white;
            font-weight: 350;
            border: none;
            padding: 8px 24px;
            border-radius: 12px;
            font-size: 1rem;
            margin-left: 10px;
            width: 140px;
        }

        .custom-cancel:hover {
            background-color: #bb3f3f;
        }

        .custom-logout:hover {
            background-color: #3a3890;
        }
    </style>
</head>

<body>
    <header class="d-flex align-items-center shadow-sm bg-white px-4 position-fixed w-100"
        style="height: 80px; z-index: 1050;">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            {{-- โลโก้ --}}
            <div class="logo">
                <h5 class="text-primary fw-bold "><img style="width: 180px; height: 100px;"
                        src="{{ asset('/public/image/logo.png') }}" alt="Website Logo"> </h5>
            </div>

            {{-- Logout  --}}
            <div class="dropdown">
                <a class="nav-link  d-flex align-items-center text-dark" href="#" id="profileDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="profileDropdown"
                    style="border-radius: 12px;">
                    <li>
                        <a class="dropdown-item text-danger d-flex align-items-center" href="#"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fa-solid fa-power-off me-2"></i> ออกจากระบบ
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header border-0 justify-content-center">
                    <h5 class="modal-title fw-bold logout-title" id="logoutModalLabel">ยืนยันการออกจากระบบ</h5>
                </div>
                <div class="modal-body">
                    <i class="bi bi-box-arrow-right" style="color: #DC3545; font-size: 4rem;"></i>
                    <h5 class="mt-3">คุณต้องการออกจากระบบหรือไม่?</h5>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn custom-cancel" data-bs-dismiss="modal">ยกเลิก</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn custom-logout">ออกจากระบบ</button>
                    </form>
                </div>
        </div>
        {{-- โปรไฟล์  --}}
        <div class="dropdown">
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

</body>

</html>
