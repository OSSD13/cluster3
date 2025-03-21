<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;

Route::get('/layoutA', function () {
    return view('layouts.admin_layouts');
});

Route::get('/feature-home-table', function () {
    return view('feature_home_table');
});

Route::get('/layoutE', function () {
    return view('layouts.employee_layouts');
});

Route::get('/form', function () {
    return view('create_form');
})->name('create-form');

// ทดลองใส่หน้าแรกเฉยๆ
Route::get('/main', function () {
    return view('create_form');
})->name('main-page');
