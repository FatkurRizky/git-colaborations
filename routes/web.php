<?php

use App\Http\Controllers\RekonKasController;
use App\Models\RekonKas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

// Kita gunakan redirect langsung ke login agar tidak dobel
Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $rekons = RekonKas::orderBy('rekon_date', 'desc')->take(7)->get()->reverse();
        $chartLabels = [];
        $chartData = [];

        foreach ($rekons as $rekon) {
            $chartLabels[] = Carbon::parse($rekon->rekon_date)->locale('id')->translatedFormat('d-m-y');
            $chartData[] = $rekon->difference;
        }
        $latestRekon = RekonKas::orderBy('rekon_date', 'desc')->first();

        $totalKasHariIni = $latestRekon ? $latestRekon->actual_cash : 0;

        $statusTerakhir = $latestRekon ? $latestRekon->status : '-';

        $totalSelisihBulanIni = RekonKas::whereMonth('rekon_date', Carbon::now()->month)->whereYear('rekon_date', Carbon::now()->year)->sum('difference');

        return view('dashboard', compact('chartLabels', 'chartData', 'totalKasHariIni', 'statusTerakhir', 'totalSelisihBulanIni'));
    })->name('dashboard');

    Route::get('/rekon-kas/export/pdf', [RekonKasController::class, 'exportPdf'])->name('rekon.export.pdf');
    Route::get('/rekon-kas/export/excel', [RekonKasController::class, 'exportExcel'])->name('rekon.export.excel');

    Route::resource('rekon-kas', RekonKasController::class)->parameters(['rekon-kas' => 'rekonKas']);

    // Ditambahkan titik koma (;) di akhir baris ini
    Route::view('/dashboard', 'dashboard')->name('dashboard'); 
    
    Route::resource('rekon-kas', RekonKasController::class)->parameters(['rekon-kas' => 'rekon_kas']);
    
    Route::get('/rekon-kas/export/pdf', [RekonKasController::class, 'exportPdf'])->name('rekon.export.pdf');
    Route::get('/rekon-kas/export/excel', [RekonKasController::class, 'exportExcel'])->name('rekon.export.excel');
});

require __DIR__.'/auth.php';