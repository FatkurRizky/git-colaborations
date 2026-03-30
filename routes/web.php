<?php

use App\Http\Controllers\DailyReconController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/rekon', [DailyReconController::class, 'index'])->name('rekon.index');
Route::post('/rekon', [DailyReconController::class, 'store'])->name('rekon.store');