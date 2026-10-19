<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/encyclopaedia', [FrontendController::class, 'index'])->name('encyclopaedia.get');

Route::get('/test', [FrontendController::class, 'test'])->name('encyclopaedia.test');
