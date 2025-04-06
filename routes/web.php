<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/draft_list', [DraftController::class, 'getShowDraft']);

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

Route::get('/draft', function() {
    return view('draft_details');
});

Route::delete('/draft/{id}', [DraftController::class, 'destroy'])->name('drafts.destroy');
    return view('draft_details');


