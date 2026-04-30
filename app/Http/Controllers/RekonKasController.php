<?php

namespace App\Http\Controllers;

use App\Models\RekonKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Exports\RekonExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage; // <-- WAJIB TAMBAH INI UNTUK HAPUS FILE

class RekonKasController extends Controller
{
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
            // TAMBAHAN: Validasi file bukti nota
            'proof_of_expense' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'], 
        ]);

        $expected_cash = ($validated['opening_cash'] + $validated['cash_income']) - $validated['operational_cash'];
        $difference = $validated['actual_cash'] - $expected_cash;

        // TAMBAHAN: Proses Upload File
        $proofPath = null;
        if ($request->hasFile('proof_of_expense')) {
            // Simpan ke folder 'storage/app/public/proofs'
            $proofPath = $request->file('proof_of_expense')->store('proofs', 'public');
        }
        
        RekonKas::create([
            ...$validated,
            'non_cash_income'  => $validated['non_cash_income'] ?? 0,
            'difference'       => $difference,
            'status'           => $difference == 0 ? 'sesuai' : 'selisih kurang', // Perbaikan status jika perlu
            'created_by'       => Auth::id(),
            'proof_of_expense' => $proofPath, // Masukkan path ke database
        ]);

        return redirect()->route('rekon-kas.index')->with('success', 'Data rekon berhasil ditambahkan.');
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
            // TAMBAHAN: Validasi file bukti nota
            'proof_of_expense' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
        ]);

        $expected_cash = ($validated['opening_cash'] + $validated['cash_income']) - $validated['operational_cash'];
        $difference = $validated['actual_cash'] - $expected_cash;

        // TAMBAHAN: Proses Update File
        $proofPath = $rekonKas->proof_of_expense; // Ambil file lama sebagai default

        if ($request->hasFile('proof_of_expense')) {
            // Hapus file lama dari server jika ada
            if ($proofPath && Storage::disk('public')->exists($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }
            
            // Simpan file baru
            $proofPath = $request->file('proof_of_expense')->store('proofs', 'public');
        }

        $rekonKas->update([
            ...$validated,
            'non_cash_income'  => $validated['non_cash_income'] ?? 0,
            'difference'       => $difference,
            'status'           => $difference == 0 ? 'sesuai' : 'selisih kurang',
            'proof_of_expense' => $proofPath, // Update database
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