{{--
test_admin.blade.php
Display form after login by admin
@input : emp_email, emp_password
@output : test form after login
@author : Supasit Meedecha 66160098
@Create Date : 2025-04-04
--}}
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<body>
    <h1>ยินดีต้อนรับ Admin: {{ $user->emp_name }} , รหัส {{ $user->emp_id }}</h1>

    <form method="GET" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <h2>รายการผู้ดูแลระบบ</h2>
    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>รหัสพนักงาน</th>
                <th>ชื่อ</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->emp_id }}</td>
                    <td>{{ $employee->emp_name }}</td>
                    <td>{{ $employee->emp_username }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
