<?php

use App\Http\Controllers\WorkRequestController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/main', function () {
    return view('test1');
});

Route::get('/archrive',   [WorkRequestController::class,'archrive'])->name('archrive');

Route::get('/show', [WorkRequestController::class, 'showDetail'])->name('main-page');

Route::get('/sent',   [WorkRequestController::class,'sent'])->name('sent');