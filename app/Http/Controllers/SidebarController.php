<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SidebarController extends Controller
{
    //
    public function setActiveMenu(Request $request)
    {
        session(['active_menu' => $request->menu]);
        return response()->json(['status' => 'success']);
    }
}
