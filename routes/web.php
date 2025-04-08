<?php

use Illuminate\Support\Facades\Route;

Route::get('/draft', function () {
    return view('draft_details');
});
