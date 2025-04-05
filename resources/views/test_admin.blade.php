<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>ยินดีต้อนรับ Admin: {{ $user->emp_name }}</h1>
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
                {{--<th>แผนก</th>--}}
                {{--<th>บทบาท</th>--}}
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->emp_id }}</td>
                    <td>{{ $employee->emp_name }}</td>
                    <td>{{ $employee->emp_username }}</td>
                    {{-- <td>{{ $employee->emp_dept_id }}</td> --}}
                    {{-- <td>{{ $employee->emp_role }}</td> --}}
                    {{--
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
                    --}}
                    {{--
                    <td>
                        @if ($employee->emp_role == 'A')
                            ผู้ดูแลระบบ
                        @elseif($employee->emp_role == 'E')
                            พนักงาน
                        @else
                            ไม่ทราบตำแหน่ง
                        @endif
                    </td>
                    --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

