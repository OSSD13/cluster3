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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">ยืนยันการออกจากระบบ</h5>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-box-arrow-right" style="color: #DC3545; font-size: 4rem;"></i>
                    <div class="confirmation-text">
                        <h5>คุณต้องการออกจากระบบหรือไม่?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">ยกเลิก</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-save">ออกจากระบบ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
