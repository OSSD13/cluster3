{{--
* employee_layouts.blade.php
* Layout for employee dashboard
*
* @input : -
* @output : Employee_layout_with_header_and_sidebar
* @author : Sarocha Dokyeesun 66160097
* @Create Date : 2025-03-18
--}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    {{-- Google Material Icons  --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- เรียกใช้ฟอนต์จาก Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('public\css\pages\report_table_style.css') }}">
    <link rel="stylesheet" href="{{ asset('public\css\pages\report_statistic_style.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }

        main {
            margin-left: 250px;
            /* ให้เนื้อหาเริ่มหลัง Sidebar */
            padding-top: 90px;
            /* เผื่อให้ตัวหนังสือไม่โดน Header บัง */
        }
    </style>


</head>

<body>
    <div class="d-flex">
        <div class="flex-grow-1">
            {{-- Sidebar --}}
            @include('layouts.side_bar_employee')
            {{-- Header --}}
            @include('layouts.header')

            {{-- Content Area --}}
            <main class="container-fluid" style="margin-left: 250px">
                @yield('content')
            </main>
        </div>
    </div>
    @yield('script')
</body>
</html>
