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
    Route::get('/rekon-kas/export/pdf', [RekonKasController::class, 'exportPdf'])->name('rekon.export.pdf');
    Route::get('/rekon-kas/export/excel', [RekonKasController::class, 'exportExcel'])->name('rekon.export.excel');
    });


require __DIR__.'/auth.php';
