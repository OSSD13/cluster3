<?php

use App\Http\Controllers\ManageEmployeeControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\WrsTaskController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\WorkRequestController;


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
    Route::get('/main', [WorkRequestController::class, 'index'])->name('main-page');
    Route::get('/archive',   [WorkRequestController::class, 'archive'])->name('archive');
    Route::get('/show/{id}', [WorkRequestController::class, 'showDetail'])->name('show');
    Route::put('/show/{id}', [WorkRequestController::class, 'updateTask'])->name('update-task');
    Route::get('/more_detail/{id}', [WorkRequestController::class, 'moreDetail'])->name('more_detail');
    Route::get('/archive-detail/{id}', [WorkRequestController::class, 'archiveDetail'])->name('archive_detail');
    Route::get('/archive-detail-self/[{id}/{empId}', [WorkRequestController::class, 'archiveDetailSelf'])->name('archive_detail_self');
    

    Route::get('/sent',   [WorkRequestController::class, 'sent'])->name('send');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get(
    '/',
    [LoginController::class, 'index']
);




Route::get('/main', [App\Http\Controllers\WorkRequestController::class, 'index'])->name('main-page');
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
