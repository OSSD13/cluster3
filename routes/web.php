<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\DepartmentController;


Route::get('/manage_department', function () {
    return view('admin.manage_department');
});


Route::get('/manage_department', [DepartmentController::class, 'showDepartments'])->name('manage-department');
Route::post('/manage_department', [DepartmentController::class, 'createDepartment'])->name('department.createDepartment');
Route::put('/manage_department/{id}', [DepartmentController::class, 'updateDepartment'])->name('department.updateDepartment');
Route::delete('/manage_department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('department.deleteDepartment');
Route::get('/search', [DepartmentController::class, 'searchDepartment']);

