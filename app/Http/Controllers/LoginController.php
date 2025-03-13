<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Auth;
>>>>>>> 454b777bf070994f42c9e946e79df980db1e128e
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    function index()
    {
<<<<<<< HEAD
        return view('login');
    }
    function login(Request $req)
    {
        //print_r($req->input());
        $user = User::where('email', $req->email)->first();
        //print_r($user);
        if ($user != null && Hash::check($req->password, $user->password)) {
            $req->session()->put('user', $user);
            return redirect('/users');
        } else {
            $req->session()->flash('error', 'กรุณาตรวจสอบข้อมูลอีกครั้ง');
            return redirect('/login');
        }
=======
        return view("login");  
    }
    function login(Request $req){
        $user = User::where('email',$req->email)->first();
>>>>>>> 454b777bf070994f42c9e946e79df980db1e128e
    }
