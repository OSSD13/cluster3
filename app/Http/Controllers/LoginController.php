<?php
/*
* Login
* Login Control
* @author : Supasit Meedecha 66160098
* @Create Date : 2025-04-05
*/

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    /*
    * login(Request $request)
    * Show login page
    * @input : emp_username ,emp_password ,emp_role
    * @output : home employee page , department page
    * @author : supasit Meedecha 66160098
    * @Create Date : 2025-04-05
    */
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
                return redirect()->to('/empDashboard'); //<--เดี่๋ยวเอา path Home ของพนักงานมาใส่
            } elseif ($user->emp_role == 'A') {
                Session::put('employees', Employee::where('emp_role', 'A')->get());
                return redirect()->to('/manage_employee');
            }


        } else {
            // ถ้า username หรือ password ผิด ให้ส่งกลับไปหน้า login พร้อมข้อความแจ้งเตือน
            return redirect('/login')->withErrors([
                'login' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณากรอกข้อมูลใหม่อีกครั้ง'
            ]);
        }
    }
    /*
    * index()
    * Show login page
    * @input : emp_username ,emp_password ,emp_role
    * @output : home employee page , department page
    * @author : supasit Meedecha 66160098
    * @Create Date : 2025-04-04
    */
    public function index()
    {
        return view('login');
    }
    /*
    * logout(Request $request)
    * Logout user and redirect to login page
    * @input : emp_id
    * @output : login page
    * @author : supasit Meedecha 66160098
    * @Create Date : 2025-04-05
    */
    public function logout(Request $request)
    {
        // ลบข้อมูล session
        $request->session()->flush();
        // เปลี่ยนเส้นทางกลับไปยังหน้า login
        return redirect('/login');
    }
}

