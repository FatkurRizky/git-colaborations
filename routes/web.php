<?php

use App\Http\Controllers\RekonKasController;
use App\Http\Controllers\DashboardController; 
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  
    Route::get('/rekon-kas/export/pdf', [RekonKasController::class, 'exportPdf'])->name('rekon.export.pdf');
    Route::get('/rekon-kas/export/excel', [RekonKasController::class, 'exportExcel'])->name('rekon.export.excel');

    Route::resource('rekon-kas', RekonKasController::class)->parameters([
        'rekon-kas' => 'rekonKas'
    ]);

});

require __DIR__.'/auth.php';