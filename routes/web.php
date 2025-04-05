<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReportController;

Route::get('/department', [DepartmentController::class, 'showDepartments'])->name('manage-department');
Route::post('/department', [DepartmentController::class, 'createDepartment'])->name('department.createDepartment');
Route::put('/department/{id}', [DepartmentController::class, 'updateDepartment'])->name('department.updateDepartment');
Route::delete('/department/{id}', [DepartmentController::class, 'deleteDepartment'])->name('department.deleteDepartment');
Route::get('/search-dept', [DepartmentController::class, 'searchDepartment']);

Route::get('/report-stat', [ReportController::class, 'showReportStat'])->name('report-stat');
Route::get('/report-table', [ReportController::class, 'showReportTable'])->name('report-data');

