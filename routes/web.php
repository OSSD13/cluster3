<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\DepartmentController;


Route::get('/manage_department', function () {
    return view('admin.manage_department');
});


Route::get('/department', [DepartmentController::class, 'showDepartments'])->name('manage-department');
Route::post('/department', [DepartmentController::class, 'createDepartment'])->name('department.createDepartment');
Route::put('/department/{id}', [DepartmentController::class, 'updateDepartment'])->name('department.updateDepartment');
Route::delete('/department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('department.deleteDepartment');
Route::get('/search-dept', [DepartmentController::class, 'searchDepartment']);

