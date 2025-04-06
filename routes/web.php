<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\WrsTaskController;

Route::get('/layoutA', function () {
    return view('layouts.admin_layouts');
});

Route::get('/layoutE', function () {
    return view('layouts.employee_layouts');
});

Route::get('/form', function () {
    return view('create_form');
})->name('create-form');


Route::get('/main', function () {
    return view('home_table');
})->name('main-page');

Route::get('/main', [App\Http\Controllers\WrsTaskController::class, 'index'])->name('main-page');
