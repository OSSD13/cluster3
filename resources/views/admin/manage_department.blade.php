{{--
* manage_department.blade.php
* list name deaprtment and manage department (add , edit , delete)
* @input : dept_name
* @output : new department
* @author : Natthanan Sirisurayut 66160352
* @Create Date : 2025-03-19
--}}
@extends('layouts.admin_layouts')

@section('content')
<div class="col-md-12 content">
    <div class="header d-flex justify-content-between align-items-center">
        <div class="h3">จัดการแผนก</div>

        <div class="position-relative" style="max-width: 386px;">
            <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3"></i>
            <input type="text" name="search" id="search" class="form-control ps-5 rounded-4 shadow-sm" placeholder="Search">
        </div>
    </div>

    <button class="btn btn-primary add-btn mb-3" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
        <i class="bi bi-plus"></i> เพิ่มแผนก
    </button>

    <table class="table table-hover">
        <thead>
            <tr class="table-active">
                <th class="ps-5">แผนก</th>
                <th class="text-end">จัดการ</th>
            </tr>
        </thead>
        <tbody class="alldata">
            @foreach ($departments as $department)
            <tr>
                <td class="ps-5">{{ $department->dept_name }}</td>
                <td class="text-end">
                    <i class="bi bi-pencil action-icon" data-bs-toggle="modal" data-bs-target="#editDepartmentModal{{ $department->dept_id }}"></i>
                    <i class="bi bi-trash action-icon" data-bs-toggle="modal" data-bs-target="#deleteDepartmentModal{{ $department->dept_id }}"></i>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tbody id="content" class="searchdata">

        </tbody>
    </table>
</div>
@include('components.department_modal')

@section('script')
<script>
    /*
    * alert message
    * alert message
    * @input : alert message
    * @output : alert message
    * @author : Naphat Maneechansuk 66160099
    * @Create Date : 2025-04-09
    */
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: '{{ session('error') }}',
            showConfirmButton: false, // ซ่อนปุ่มตกลง
            timer: 3000 // ปิดอัตโนมัติใน 3 วินาที
        });
    @endif
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '{{ session('success') }}',
            showConfirmButton: false, // ซ่อนปุ่มตกลง
            timer: 3000 // ปิดอัตโนมัติใน 3 วินาที
        });
    @endif

    /*
    * searchDepartments()
    * search department
    * @input : department name
    * @output : department name in table
    * @author : Natthanan Sirisurayut 66160352
    * @Create Date : 2025-04-04
    */
    function searchDepartments() {
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
            url: '{{URL::to('search-dept')}}',
            data: { 'search': $value },

            success: function(data) {
                if (data.trim() === "") {
                    // No results found
                    $('#content').html('<tr><td colspan="2" class="text-center">ไม่พบข้อมูล</td></tr>');
                } else {
                    $('#content').html(data);
                }
            }
        });
    }

    $(document).ready(function() {
        $('#search').on('keyup', searchDepartments);
    });
</script>
@endsection
@endsection
