<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\DepartmentController;


Route::get('/manage_department', function () {
    return view('admin.manage_department');
});


Route::get('/manage_department', [DepartmentController::class, 'showDepartments'])->name('manage-department');
Route::post('/manage_department', [DepartmentController::class, 'createDepartment'])->name('department.createDepartment');
