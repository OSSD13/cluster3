<?php

use App\Http\Controllers\ManageEmployeeControler;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\EditDraftController;
use App\Http\Controllers\EmployeeController;
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
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/draft_list', [DraftController::class, 'getShowDraft'])->name('draft_list');

    // Route สำหรับแก้ไขแบบร่าง
    Route::get('/draft/{id}/edit', [EditDraftController::class, 'edit'])->name('draft.edit');

    // Route สำหรับอัปเดตแบบร่าง
    Route::put('/draft/{id}', [EditDraftController::class, 'update'])->name('draft.update');

    // Route สำหรับลบใบงาน
    Route::delete('/draft/{id}', [DraftController::class, 'destroy'])->name('drafts.destroy');

    // Route สำหรับดึงข้อมูลพนักงานตามแผนก
    Route::get('/form/employee/{deptId}', [EmployeeController::class, 'getEmployeesByDepartment']);

    // layout admin
    Route::get('/layoutA', function () {
        return view('layouts.admin_layouts');
    });

    //layout employee
    Route::get('/layoutE', function () {
        return view('layouts.employee_layouts');
    });

    // route ของการเรียกหน้า view ของการสร้างใบสั่งงาน
    Route::get('/form', function () {
        return view('create_form');
    })->name('create-form');

    //เรียกไปหน้า details draft
    Route::get('/draft', function () {
        return view('draft_details');
    })->name('draft_deatails');
    Route::get('/draft_list', [DraftController::class, 'getShowDraft'])->name('draft_list');

    // Route สำหรับแสดงแบบร่าง (แสดงรายการ)
Route::get('/draft/{id}', [EditDraftController::class, 'index'])->name('draft.index');

// Route สำหรับแก้ไขแบบร่าง
Route::get('/draft/{id}', [EditDraftController::class, 'edit'])->name('draft.edit');

// Route สำหรับอัปเดตแบบร่าง
Route::put('/draft/{id}', [EditDraftController::class, 'update'])->name('draft.update');

// Route สำหรับลบใบงาน
Route::delete('/draft/{id}', [DraftController::class, 'destroy'])->name('drafts.destroy');

// Route สำหรับดึงข้อมูลพนักงานตามแผนก
Route::get('/form/employee/{deptId}', [EmployeeController::class, 'getEmployeesByDepartment']);

//สำหรับบันทึกฟอร์ม
Route::get('/draft/update', [EditDraftController::class, 'update'])->name('draft.update');

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
