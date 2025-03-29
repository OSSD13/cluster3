<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SidebarController;


Route::get('/manage_department', function () {
    return view('admin.manage_department');
});



Route::get('/manage_department', function () {
    return view('admin.manage_department');
})->name('manage-department');
