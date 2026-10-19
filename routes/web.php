<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/encyclopaedia', [FrontendController::class, 'index'])->middleware('throttle:characters')->name('encyclopaedia.get');
