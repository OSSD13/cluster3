<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;


Route::get('/manage_department', function () {
    return view('admin.manage_department');
});

Route::get('/form', function () {
    return view('create_form');
})->name('create-form');

// ทดลองใส่หน้าแรกเฉยๆ
Route::get('/main', function () {
    return view('create_form');
})->name('main-page');
