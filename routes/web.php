<?php

use App\Http\Controllers\ManageEmployeeControler;
use Illuminate\Support\Facades\Route;
/*
    * manage_employee
    * Route for manage employee
    * @input : -
    * @output : -
    * @author : Naphat Maneechansuk 66160099
    * @Create Date : 2025-04-04
*/

Route::get('/', [ManageEmployeeControler::class, 'showEmployee'])->name('manage_employee.showDepartments');
Route::get('/manage_department', [ManageEmployeeControler::class, 'showEmployee'])->name('manage_employee.showDepartments');
Route::put('/edit/{id}', [ManageEmployeeControler::class, 'editEmployee'])->name('manage_employee_edit');
Route::get('/search_employee', [ManageEmployeeControler::class, 'searchEmployee'])->name('manage_employee_search');
