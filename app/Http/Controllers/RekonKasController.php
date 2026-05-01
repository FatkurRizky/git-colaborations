<?php

namespace App\Http\Controllers;

use App\Models\RekonKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Exports\RekonExport;
use Maatwebsite\Excel\Facades\Excel;

class RekonKasController extends Controller
{
    // Index sudah OK (Saran: tambahkan handle error jika filter kosong)
    public function index(Request $request)
    {
        $rekons = RekonKas::with('creator')
            ->when($request->start_date, fn($q) => $q->whereDate('rekon_date', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('rekon_date', '<=', $request->end_date))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest('rekon_date')
            ->paginate(10)
            ->withQueryString();

        return view('rekon-kas.index', compact('rekons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rekon_date'       => ['required', 'date'],
            'opening_cash'     => ['required', 'numeric', 'min:0'],
            'cash_income'      => ['required', 'numeric', 'min:0'],
            'non_cash_income'  => ['nullable', 'numeric', 'min:0'],
            'operational_cash' => ['required', 'numeric', 'min:0'],
            'actual_cash'      => ['required', 'numeric', 'min:0'],
            'notes'            => ['nullable', 'string'],
        ]);

    
        $expected_cash = ($validated['opening_cash'] + $validated['cash_income']) - $validated['operational_cash'];
        $difference = $validated['actual_cash'] - $expected_cash;
        
        RekonKas::create([
            ...$validated,
            'non_cash_income' => $validated['non_cash_income'] ?? 0,
            'difference'      => $difference,
            'status'          => $difference == 0 ? 'sesuai' : 'selisih',
            'created_by'      => Auth::id(),
        ]);

        return redirect()->route('rekon-kas.index')->with('success', 'Data rekon berhasil dihitung otomatis.');
    }

    public function show(RekonKas $rekonKas) 
    {
        $rekonKas->load('creator');
        return view('rekon-kas.show', compact('rekonKas'));
    }

    public function create()
    {   
        $rekonKas = new \App\Models\RekonKas();
        return view('rekon-kas.create', compact('rekonKas'));
    }

    public function edit(RekonKas $rekonKas)
    {
        return view('rekon-kas.edit', compact('rekonKas'));
    }

    public function update(Request $request, RekonKas $rekonKas)
    {
        $validated = $request->validate([
            'rekon_date'       => ['required', 'date'],
            'opening_cash'     => ['required', 'numeric', 'min:0'],
            'cash_income'      => ['required', 'numeric', 'min:0'],
            'non_cash_income'  => ['nullable', 'numeric', 'min:0'],
            'operational_cash' => ['required', 'numeric', 'min:0'],
            'actual_cash'      => ['required', 'numeric', 'min:0'],
            'notes'            => ['nullable', 'string'],
        ]);

        // Hitung ulang selisih jika ada perubahan angka
        $expected_cash = ($validated['opening_cash'] + $validated['cash_income']) - $validated['operational_cash'];
        $difference = $validated['actual_cash'] - $expected_cash;

        $rekonKas->update([
            ...$validated,
            'difference' => $difference,
            'status'     => $difference == 0 ? 'sesuai' : 'selisih',
        ]);

        return redirect()->route('rekon-kas.index')->with('success', 'Data diperbarui & selisih dihitung ulang.');
    }

    public function exportPdf()
    {
        try {
            ini_set('memory_limit', '256M');
            $rekons = RekonKas::with('creator')->latest()->get();
            
            $pdf = Pdf::loadView('rekon-kas.pdf', compact('rekons'));
            return $pdf->setPaper('a4', 'landscape')->download('Laporan-Rekon-'.now()->format('Y-m-d').'.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    public function exportExcel()
    {
        return Excel::download(new \App\Exports\RekonExport, 'Laporan-Rekon-' . date('Y-m-d') . '.xlsx');
    }
}