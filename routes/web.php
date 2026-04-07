<?php

use App\Http\Controllers\RekonKasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::resource('rekon-kas', RekonKasController::class);
});


require __DIR__.'/auth.php';
