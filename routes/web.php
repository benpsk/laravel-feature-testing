<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('posts', PostController::class);
});

require __DIR__ . '/auth.php';
