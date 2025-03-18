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
    <title>Admin Layouts</title>

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



</head>

<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        @include('layouts.side_bar_employee')

        <div class="flex-grow-1">
            {{-- Header --}}
            @include('layouts.header')

            {{-- Content Area --}}
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
