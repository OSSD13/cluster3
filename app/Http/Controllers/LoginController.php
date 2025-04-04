<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('emp_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // ตรวจสอบพนักงานในฐานข้อมูล
        $user = DB::table('wrs_employees')
            ->where('emp_username', $credentials['username'])
            ->where('emp_password', $credentials['password'])
            ->first();

        if ($user) {
            Session::put('user', $user);
            return redirect()->route('dashboard');  // เปลี่ยนจาก '/dashboard' เป็น 'dashboard'
        } else {
            return redirect()->route('emp_login')->withErrors(['login' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง']);
        }
    }

    public function dashboard()
    {
        if (!Session::has('user')) {
            return redirect()->route('emp_login'); // เปลี่ยนจาก '/emp_login' เป็น 'emp_login'
        }

        $user = Session::get('user');
        $employees = DB::table('wrs_employees')->get();

        return view('dashboard', compact('user', 'employees'));
    }

}
