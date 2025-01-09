<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MessageController::class, 'index'])->name('welcome');
Route::post('/messages', [MessageController::class, 'store'])->name('chat.store');
