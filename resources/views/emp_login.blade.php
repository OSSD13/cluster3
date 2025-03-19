{{--
emp_login.blade.php
Display form login by employee
@input : emp_email, emp_password
@output : form login
@author : Supasit Meedecha 66160098
@Create Date : 2025-03-19
--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('public\css\emp_login_style.css') }}">
    <title>Employee - Login</title>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <img src="{{ asset('public\image\logo.png') }}" alt="Website Logo">
            <form action="#" method="post">
                <label for="username">ชื่อผู้ใช้</label>
                <input type="text" id="username" name="username" placeholder="กรอกชื่อผู้ใช้" required>

                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" placeholder="***************" required>

                <button type="submit">เข้าสู่ระบบ</button>
            </form>
            <p1>เข้าสู่ระบบ พนักงาน</p1>
        </div>
    </div>
</body>
</html>


