<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    function index()
    {
        return view("login");  
    }
    function login(Request $req){
        $user = User::where('email',$req->email)->first();
    }
