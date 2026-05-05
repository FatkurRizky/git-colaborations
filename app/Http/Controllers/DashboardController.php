<?php

namespace App\Http\Controllers;

use App\Models\RekonKas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('chart_month', Carbon::now()->format('Y-m'));
        $parsedMonth = Carbon::createFromFormat('Y-m', $selectedMonth);

    
        $grafikData = RekonKas::whereYear('rekon_date', $parsedMonth->year)
            ->whereMonth('rekon_date', $parsedMonth->month)
            ->orderBy('rekon_date', 'asc')
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->rekon_date)->format('d/m/y');
            });

        $chartLabels = [];
        $chartData = [];

        foreach ($grafikData as $tanggal => $data) {
            $chartLabels[] = $tanggal;
            $chartData[] = $data->sum('difference'); 
        }

        $latestRekon = RekonKas::orderBy('rekon_date', 'desc')->first();

        $totalKasHariIni = $latestRekon ? $latestRekon->actual_cash : 0;
        
        $statusTerakhir = $latestRekon ? $latestRekon->status : '-';      
        
        $totalSelisihBulanIni = RekonKas::whereMonth('rekon_date', Carbon::now()->month)
            ->whereYear('rekon_date', Carbon::now()->year)
            ->sum('difference');

   
        $monthOptions = [];
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths($i);
            $monthOptions[$date->format('Y-m')] = $date->translatedFormat('F Y'); 
        }

        return view('dashboard', compact(
            'chartLabels', 
            'chartData', 
            'totalKasHariIni', 
            'statusTerakhir', 
            'totalSelisihBulanIni',
            'selectedMonth',
            'monthOptions'
        ));
    }
}