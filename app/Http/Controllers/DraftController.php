<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function showDrafts()
{
    // ดึงข้อมูลแบบร่างจากฐานข้อมูล
    // ดึงข้อมูลจากตาราง 'wrs_work_requests'
    $data = DB::table('wrs_work_requests')->first();

    return response()->json($data);
}
}
