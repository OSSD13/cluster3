<?php

use Illuminate\Support\Facades\Route;

Route::get('/layoutA', function () {
    return view('components.admin_layouts');
});

Route::get('/layoutE', function () {
    return view('components.employee_layouts');
});

Route::get('/detail', function () {
    return view('send_detail');
});
