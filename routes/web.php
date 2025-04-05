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


Route::get('/',
    [LoginController::class, 'index']);

Route::get('/login', function () {
    return view('login');
});

Route::post('/login',
    [LoginController::class, 'login'])->name('login');

Route::get('/logout',
    [LoginController::class, 'logout'])->name('logout');


    Route::get('/adminDashboard', function () {
        $user = session('user');
        $employees = session('employees');
        return view('test_admin', compact('user', 'employees'));
    })->middleware('admin')->name('adminDashboard');

    Route::get('/empDashboard', function () {
        $user = session('user');
        $employees = session('employees');
        return view('test_emp', compact('user', 'employees'));
    })->middleware('employee')->name('empDashboard');

/*
Route::get('/empDashboard', function () {
    $user = session('user');
    $employees = session('employees');
    return view('test_emp', compact('user', 'employees'));
    })->name('empDashboard');

Route::get('/adminDashboard', function () {
    $user = session('user');
    $employees = session('employees');
    return view('test_admin', compact('user', 'employees'));
    })->name('adminDashboard');
*/
    /*
Route::get('/empDashboard', function () {
    $user = session('user');
    // ดึงเฉพาะพนักงาน (emp_role = 'E')
    $employees = \App\Models\Employee::where('emp_role', 'E')->get();
    return view('test_emp', ['user' => $user, 'employees' => $employees]);})->middleware('auth')->name('empDashboard');

Route::get('/adminDashboard', function () {
    $user = session('user');
    $employees = \App\Models\Employee::where('emp_role', 'A')->get();
    return view('test_admin', ['user' => $user, 'employees' => $employees]);})->middleware('auth')->name('adminDashboard');

*/
/*
// แสดงหน้า Dashboard ตามสิทธิ์
Route::get('/adminDashboard', function () {
    return view('test_admin', ['user' => session('user')]);
})->middleware('auth')->name('adminDashboard');

Route::get('/empDashboard', function () {
    return view('test_emp', ['user' => session('user')]);
})->middleware('auth')->name('empDashboard');
*/
