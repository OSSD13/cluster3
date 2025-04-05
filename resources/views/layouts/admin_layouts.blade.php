{{--
* admin_layouts.blade.php
* Layout for admin dashboard
*
* @input : -
* @output : Admin layout with header and sidebar
* @author : Sarocha Dokyeesun 66160097
* @Create Date : 2025-03-17
--}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200;300;400;600;700&display=swap" rel="stylesheet">


    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    {{-- Google Material Icons  --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('public\css\pages\manage_department_style.css') }}">
    <link rel="stylesheet" href="{{ asset('public\css\manage_employee.css') }}">

    {{-- Bosstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


</head>
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <div class="flex-grow-1">
            {{-- Sidebar --}}
            @include('layouts.side_bar_admin')
            {{-- Header --}}
            @include('layouts.header')

            {{-- Content Area --}}
            <main class="container-fluid" style="margin-left: 250px">
                @yield('content')
            </main>
        </div>
    </div>
    {{-- Custom JS --}}
    @yield('script') <!-- Moved here to ensure scripts are included -->

</body>

</html>
