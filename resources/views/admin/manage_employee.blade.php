{{--
sent_table.blade.php
Display form show table manage employee
@input : emp_id, emp_name, dept_id
@output : form show table manage employee
@author : Naphat Maneechansuk 66160099
@Create Date : 2025-04-05
--}}
@extends('layouts.admin_layouts')

@section('content')
    <div class="container mt-4 content">
        <div class="row mb-3 d-flex align-items-center justify-content-between">
            <div class="col-md-6 d-flex align-items-center">
                <h2 class="mb-0 text-header">จัดการพนักงาน</h2>
            </div>
            <div class="position-relative" style="max-width: 386px;">
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                <input type="text" name="search" id="search" class="form-control ps-5 rounded-4 shadow-sm"
                    placeholder="Search">
            </div>
        </div>
        <table class="table table-hover">
            <thead class="table-secondary">
                <tr>
                    <th class="col-2 text-center">รหัสพนักงาน</th>
                    <th class="col-4 text-center">ชื่อ-นามสกุล</th>
                    <th class="col-1 text-center"></th>
                    <th class="col-3 text-center">แผนก</th>
                    <th class="col-2 text-center"></th>
                </tr>
            </thead>
            <tbody class="alldata text-center">
                @foreach ($employees as $employee)
                    <tr>
                        <th scope="row">{{ str_pad($employee->emp_id, 4, '0', STR_PAD_LEFT) }}</th>
                        <td>{{ $employee->emp_name }}</td>
                        <td></td>
                        <td>{{ $employee->department->dept_name }}</td>
                        <td><i class="bi bi-pencil action-icon" data-bs-toggle="modal"
                                data-bs-target="#editEmployeeModal{{ $employee->emp_id }}"></i></td>
                    </tr>
                @endforeach
            </tbody>
            <tbody id="content" class="searchdata">
            </tbody>
        </table>
    </div>
@endsection
@include('components.employee_model')

@section('script')
    <script>
        /*
         * searchEmployee()
         * search Employee
         * @input : Employee name
         * @output : Employee name in table
         * @author : Naphat Maneechansuk 66160099
         * @Create Date : 2025-04-05
         */
        function searchEmployee() {
            var $value = $('#search').val();
            if ($value) {
                $('.alldata').hide();
                $('.searchdata').show();
            } else {
                $('.alldata').show();
                $('.searchdata').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ URL::to('search_employee') }}',
                data: {
                    'search': $value
                },
                success: function(data) {
                    if (data.trim() === "") {
                        // No results found
                        $('#content').html('<tr><td colspan="6" class="text-center">ไม่พบข้อมูล</td></tr>');
                    } else {
                        $('#content').html(data);
                    }
                }
            });
        }
        $(document).ready(function() {
            $('#search').on('keyup', searchEmployee);
        });
    </script>
@endsection
