<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // รับค่า username และ password จากฟอร์ม
        $credentials = $request->only('username', 'password');

        // ค้นหาพนักงานในฐานข้อมูล
        $user = Employee::where('emp_username', $credentials['username'])
            ->where('emp_password', $credentials['password'])
            ->first();

        if ($user) {
            // บันทึกข้อมูลลง session
            Session::put('user', $user);

            $employees = Employee::all();

            // ดึงข้อมูลพนักงานทั้งหมดจากฐานข้อมูล
            if ($user->emp_role == 'E') {
                Session::put('employees', Employee::where('emp_role', 'E')->get());
                return redirect()->to('/empDashboard');
            } elseif ($user->emp_role == 'A') {
                Session::put('employees', Employee::where('emp_role', 'A')->get());
                return redirect()->to('/adminDashboard');
            }

            /*
            $employees = Employee::all();
            if ($user->emp_role == 'E') {
                // ดึงข้อมูลเฉพาะพนักงาน (emp_role = 'E')
                $employees = Employee::where('emp_role', 'E')->get();
                return view('test_emp', ['user' => $user, 'employees' => $employees]);
            } elseif ($user->emp_role == 'A') {
                $employees = Employee::where('emp_role', 'A')->get();
                return view('test_admin', ['user' => $user, 'employees' => $employees]);
            }
            */

            // เช็คบทบาทของ user แล้วเปลี่ยนเส้นทางไปที่ view
            /*if ($user->emp_role == 'E') {
                Session::put('user', $user); // ใส่ไว้เผื่อไม่ได้อยู่ข้างบน
                return redirect()->route('empDashboard');
            } elseif ($user->emp_role == 'A') {
                Session::put('user', $user);
                return redirect()->route('adminDashboard');
            }*/


            /*
            if ($user->emp_role == 'E') {
                return view('test_emp', ['user' => $user]); // ไปหน้า Employee
            } elseif ($user->emp_role == 'A') {
                return view('test_admin', ['user' => $user]); // ไปหน้า Admin
            }
            */
        } else {
            // ถ้า username หรือ password ผิด ให้ส่งกลับไปหน้า login พร้อมข้อความแจ้งเตือน
            return redirect('/login')->withErrors([
                'login' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณากรอกข้อมูลใหม่อีกครั้ง'
            ]);
        }
    }
    public function index()
    {
        return view('login');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}

