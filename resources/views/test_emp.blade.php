{{--
test_emp.blade.php
Display form after login by employee
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
    <title>Employee Dashboard</title>
</head>
<body>
    <h1>ยินดีต้อนรับ พนักงาน: {{ $user->emp_name }}</h1>
    <form method="GET" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <h2>รายการพนักงาน</h2>
    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>รหัสพนักงาน</th>
                <th>ชื่อ</th>
                <th>Username</th>
                <th>แผนก</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->emp_id }}</td>
                    <td>{{ $employee->emp_name }}</td>
                    <td>{{ $employee->emp_username }}</td>
                    <td>
                        @if ($employee->emp_dept_id == '1')
                            ไอที
                        @elseif($employee->emp_dept_id == '2')
                            บัญชี
                        @elseif($employee->emp_dept_id == '3')
                            การตลาด
                        @else
                            ไม่มีแผนก
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
