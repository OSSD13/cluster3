<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>ยินดีต้อนรับคุณ {{ $user->emp_name }}</h2>

    <h3>รายการพนักงาน</h3>
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
            @foreach($employees as $index => $employee)
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
