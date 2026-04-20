<?php

use App\Http\Controllers\RekonKasController;
use Illuminate\Support\Facades\Route;

// Kita gunakan redirect langsung ke login agar tidak dobel
Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {
    // Ditambahkan titik koma (;) di akhir baris ini
    Route::view('/dashboard', 'dashboard')->name('dashboard'); 
    
    Route::resource('rekon-kas', RekonKasController::class)->parameters(['rekon-kas' => 'rekon_kas']);
    
    Route::get('/rekon-kas/export/pdf', [RekonKasController::class, 'exportPdf'])->name('rekon.export.pdf');
    Route::get('/rekon-kas/export/excel', [RekonKasController::class, 'exportExcel'])->name('rekon.export.excel');
});

require __DIR__.'/auth.php';