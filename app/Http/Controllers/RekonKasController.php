<?php

namespace App\Http\Controllers;

use App\Models\RekonKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Exports\RekonExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class RekonKasController extends Controller
{
    /**
     * Menampilkan daftar rekon kas dengan fitur filter dan pagination.
     */
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

    /**
     * Menyimpan data rekon baru beserta file bukti operasional.
     */
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
            'proof_of_expense' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'], 
        ]);

        $expected_cash = ($validated['opening_cash'] + $validated['cash_income']) - $validated['operational_cash'];
        $difference = $validated['actual_cash'] - $expected_cash;

        // Proses Upload File Bukti
        $proofPath = null;
        if ($request->hasFile('proof_of_expense')) {
            $proofPath = $request->file('proof_of_expense')->store('proofs', 'public');
        }
        
        RekonKas::create([
            ...$validated,
            'non_cash_income'  => $validated['non_cash_income'] ?? 0,
            'difference'       => $difference,
            'status'           => $difference == 0 ? 'sesuai' : ($difference < 0 ? 'selisih kurang' : 'selisih lebih'),
            'created_by'       => Auth::id(),
            'proof_of_expense' => $proofPath,
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

    /**
     * Memperbarui data rekon dan mengelola pergantian file bukti.
     */
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
            'proof_of_expense' => ['nullable', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:2048'],
        ]);

        $expected_cash = ($validated['opening_cash'] + $validated['cash_income']) - $validated['operational_cash'];
        $difference = $validated['actual_cash'] - $expected_cash;

        $proofPath = $rekonKas->proof_of_expense;

        if ($request->hasFile('proof_of_expense')) {
            // Hapus file lama jika ada file baru yang diupload
            if ($proofPath && Storage::disk('public')->exists($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }
            $proofPath = $request->file('proof_of_expense')->store('proofs', 'public');
        }

        $rekonKas->update([
            ...$validated,
            'non_cash_income'  => $validated['non_cash_income'] ?? 0,
            'difference'       => $difference,
            'status'           => $difference == 0 ? 'sesuai' : ($difference < 0 ? 'selisih kurang' : 'selisih lebih'),
            'proof_of_expense' => $proofPath,
        ]);

        return redirect()->route('rekon-kas.index')->with('success', 'Data diperbarui & selisih dihitung ulang.');
    }

    public function destroy(RekonKas $rekonKas)
    {
        // Hapus file bukti fisik jika ada sebelum menghapus record
        if ($rekonKas->proof_of_expense && Storage::disk('public')->exists($rekonKas->proof_of_expense)) {
            Storage::disk('public')->delete($rekonKas->proof_of_expense);
        }

        $rekonKas->delete();
        return redirect()->route('rekon-kas.index')->with('success', 'Data rekon kas berhasil dihapus.');
    }

    public function exportPdf()
    {
        try {
            ini_set('memory_limit', '256M');
            $rekons = RekonKas::with('creator')->latest('rekon_date')->get();
            
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