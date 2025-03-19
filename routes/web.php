<?php

use App\Http\Controllers\ManageEmployeeControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AdminMiddleware;


Route::middleware(['admin'])->group(function () {
    Route::get('/', [ManageEmployeeControler::class, 'showEmployee'])->name('manage_employee.showEmployees');
    Route::get('/manage_employee', [ManageEmployeeControler::class, 'showEmployee'])->name('manage_employee.showEmployees');
    Route::put('/edit/{id}', [ManageEmployeeControler::class, 'editEmployee'])->name('manage_employee_edit');
    Route::get('/search_employee', [ManageEmployeeControler::class, 'searchEmployee'])->name('manage_employee_search');

    Route::get('/department', [DepartmentController::class, 'showDepartments'])->name('manage-department');
    Route::post('/department', [DepartmentController::class, 'createDepartment'])->name('department.createDepartment');
    Route::put('/department/{id}', [DepartmentController::class, 'updateDepartment'])->name('department.updateDepartment');
    Route::delete('/department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('department.deleteDepartment');
    Route::get('/search-dept', [DepartmentController::class, 'searchDepartment']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['employee'])->group(function () {


Route::get('/layoutA', function () {
    return view('layouts.admin_layouts');
});

Route::get('/layoutE', function () {
    return view('layouts.employee_layouts');
});

Route::get('/form', function () {
    return view('create_form');
});

Route::get(
    '/',
    [LoginController::class, 'index']
);

Route::get('/login', function () {
    return view('login');
});

Route::post(
    '/login',
    [LoginController::class, 'login']
)->name('login');

Route::post(
    '/logout',
    [LoginController::class, 'logout']
)->name('logout');
/*
Route::get('/', [ManageEmployeeControler::class, 'showEmployee'])->name('manage_employee.showEmployees');
Route::get('/manage_employee', [ManageEmployeeControler::class, 'showEmployee'])->name('manage_employee.showEmployees');
Route::put('/edit/{id}', [ManageEmployeeControler::class, 'editEmployee'])->name('manage_employee_edit');
Route::get('/search_employee', [ManageEmployeeControler::class, 'searchEmployee'])->name('manage_employee_search');
*/
});
