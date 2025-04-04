<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;

Route::get('/draft', function () {
    return view('draft_details');
});

Route::get('/form', function () {
    return view('create_form');
})->name('create-form');

// ทดลองใส่หน้าแรกเฉยๆ
Route::get('/main', function () {
    return view('create_form');
})->name('main-page');
