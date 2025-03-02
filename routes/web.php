<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/test', function (Request $request) {
    return ['message' => $request];
});

require __DIR__.'/auth.php';
