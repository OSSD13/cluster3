<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkRequestController;

// http://localhost/cluster3/public/archive-detail <-- URL ที่ใช้เรียกดูข้อมูล

Route::get('/archive-detail', [WorkRequestController::class, 'index']);
