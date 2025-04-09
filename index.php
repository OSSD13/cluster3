<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/bootstrap/app.php')
    ->handleRequest(Request::capture());

    Route::get('/tasks', function () {
        // ดึงข้อมูลจากตาราง wrs_work_requests
        $myReceived = DB::table('wrs_work_requests')
            ->where('request_type', 'my')
            ->where('request_status', 'received')
            ->get();
    
        $myInProgress = DB::table('wrs_work_requests')
            ->where('request_type', 'my')
            ->where('request_status', 'in_progress')
            ->get();
    
        $myCompleted = DB::table('wrs_work_requests')
            ->where('request_type', 'my')
            ->where('request_status', 'completed')
            ->get();
    
        $deptReceived = DB::table('wrs_work_requests')
            ->where('request_type', 'department')
            ->where('request_status', 'received')
            ->get();
    
        $deptInProgress = DB::table('wrs_work_requests')
            ->where('request_type', 'department')
            ->where('request_status', 'in_progress')
            ->get();
    
        $deptCompleted = DB::table('wrs_work_requests')
            ->where('request_type', 'department')
            ->where('request_status', 'completed')
            ->get();
    
        return view('employee_task_list', compact(
            'myReceived', 'myInProgress', 'myCompleted',
            'deptReceived', 'deptInProgress', 'deptCompleted'
        ));
    });
