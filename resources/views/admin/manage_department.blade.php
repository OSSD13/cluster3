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
            <input type="text" class="form-control ps-5 rounded-4 shadow-sm" placeholder="Search">
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
        <tbody>
            <tr>
                <td class="ps-5">บัญชี (Accounting)</td>
                <td class="text-end">
                    <i class="bi bi-pencil action-icon" data-bs-toggle="modal" data-bs-target="#editDepartmentModal"></i>
                    <i class="bi bi-trash action-icon" data-bs-toggle="modal" data-bs-target="#deleteDepartmentModal"></i>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@include('components.department_modal')

@endsection
