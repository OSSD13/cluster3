{{--
emp_login.blade.php
Display form login
@input : emp_email, emp_password
@output : form login
@author : Supasit Meedecha 66160098
@Create Date : 2025-03-19
--}}

<!DOCTYPE html>
<html lang="th">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public\css\login_style.css') }}">

    <title>Login</title>
</head>

<body>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="container">
            <div class="login-box">
                <img src="{{ asset('public/image/logo.png') }}" alt="Website Logo">

                <label for="username">ชื่อผู้ใช้</label>
                <input type="text" id="username" name="username" placeholder="กรอกชื่อผู้ใช้"
                    value="{{ old('username') }}" class="{{ $errors->has('username') ? 'error-input' : '' }}">
                @if ($errors->has('username'))
                    <div class="error-text">{{ $errors->first('username') }}</div>
                @endif

                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" placeholder="***************"
                    value="{{ old('password') }}" class="{{ $errors->has('password') ? 'error-input' : '' }}">
                @if ($errors->has('password'))
                    <div class="error-text">{{ $errors->first('password') }}</div>
                @endif

                <button type="submit">เข้าสู่ระบบ</button>
            </div>
        </div>
    </form>
</body>

</html>
