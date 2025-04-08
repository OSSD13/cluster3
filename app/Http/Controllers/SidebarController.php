<!-- 
* SidebarController.php
* Controller สำหรับจัดการ Sidebar (Active Menu)
*
* @input Request $request เมนูที่ถูกเลือก
* @output บันทึกค่าเมนูที่ Active ลงใน Session
* @author Sarocha Dokyeesun
* @Create Date 2025-03-20 -->

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
