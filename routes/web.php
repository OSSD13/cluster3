<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ManageEmployeeControler,
    FormController,
    SidebarController,
    DepartmentController,
    LoginController
};
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
    Route::get('/layoutE', function () {
        return view('layouts.employee_layouts');
    });

    // หน้าแบบฟอร์มสร้างใบสั่งงาน (GET ต้องอยู่ก่อน)
    Route::get('/form', [FormController::class, 'index'])->name('form.index');

    // POST สำหรับบันทึกฟอร์ม
    Route::post('/form/create', [FormController::class, 'createWorkRequest'])->name('form.create');

    // AJAX: ดึงรายชื่อพนักงานตามแผนก
    Route::get('/form/employee/{id}', [FormController::class, 'empData'])->name('form.empData');
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
