<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkRequestController;

// http://localhost/cluster3/public/archive-detail <-- URL ที่ใช้เรียกดู

// Route for Archive table
Route::get('/archive-table', [WorkRequestController::class, 'archiveTable'])->name('archive.table');

// Route for archive_detail
Route::get('/archive-detail', [WorkRequestController::class, 'archiveDetail'])->name('archive_detail');

// Route for archive_detail_self
Route::get('/archive-detail-self', [WorkRequestController::class, 'archiveDetailSelf'])->name('archive_detail_self');
