<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/feature-home-table', function () {
    return view('feature-home-table');
});

