<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    function index()
    {
        return view("login");  
    }
    function login(Request $req){
        $user = User::where('email',$req->email)->first();
    }
}
