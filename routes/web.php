<?php
/*
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/empLogin', function () {
    return view('emp_login');
});
*/
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/empLogin', [LoginController::class, 'showLoginForm'])->name('emp_login');
Route::post('/empLogin', [LoginController::class, 'login'])->name('emp_login');
Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');


