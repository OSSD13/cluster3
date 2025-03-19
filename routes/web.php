<?php

use Illuminate\Support\Facades\Route;

Route::get('/layoutA', function () {
    return view('layouts.admin_layouts');
});

Route::get('/layoutE', function () {
    return view('layouts.employee_layouts');
});

Route::get('/form', function () {
    return view('create_form');
});
