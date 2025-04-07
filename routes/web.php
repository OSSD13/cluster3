<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkRequestController;

// http://localhost/cluster3/public/archive-detail <-- URL ที่ใช้เรียกดูข้อมูล

// Route for archive_detail
Route::get('/archive-detail', [WorkRequestController::class, 'index'])->name('archive_detail');

// Route for archive_detail_self
Route::get('/archive-detail-self', [WorkRequestController::class, 'indexSelf'])->name('archive_detail_self');

Route::get('/archive_detail', [WorkRequestController::class, 'index'])->name('archive');

Route::get('/archive_detail_self', [WorkRequestController::class, 'indexSelf'])->name('archive');
