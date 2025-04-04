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

Route::get('/Login', function () {
    return view('login');
});

Route::post('/Login',
    [LoginController::class, 'login'])->name('login');

// แสดงหน้า Dashboard ตามสิทธิ์
Route::get('/adminDashboard', function () {
    return view('test_admin', ['user' => session('user')]);
})->middleware('auth')->name('adminDashboard');

Route::get('/empDashboard', function () {
    return view('test_emp', ['user' => session('user')]);
})->middleware('auth')->name('empDashboard');

