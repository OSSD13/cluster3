<?php

use Illuminate\Support\Facades\Route;


Route::get('/manage_department', function () {
    return view('admin.manage_department');
});
