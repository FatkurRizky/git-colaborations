<?php

namespace App\Http\Controllers;

use App\Models\RekonKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekonKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RekonKas::with('creator')->latest('rekon_date');

        if ($request->filled('start_date')) {
            $query->whereDate('rekon_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('rekon_date', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rekons = $query->paginate(10)->withQueryString();

        return view('rekon-kas.index', compact('rekons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rekonKa = new RekonKas();
        return view('rekon-kas.create', compact('rekonKa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rekon_date'       => ['required', 'date'],
            'opening_cash'     => ['required', 'integer', 'min:0'],
            'cash_income'      => ['required', 'integer', 'min:0'],
            'non_cash_income'  => ['nullable', 'integer', 'min:0'],
            'operational_cash' => ['required', 'integer', 'min:0'],
            'actual_cash'      => ['required', 'integer', 'min:0'],
            'notes'            => ['nullable', 'string'],
        ]);

        $validated['non_cash_income'] = $validated['non_cash_income'] ?? 0;

        RekonKas::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('rekon-kas.index')
            ->with('success', 'Data rekon kas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RekonKas $rekonKa)
    {
        $rekonKa->load('creator');

        return view('rekon-kas.show', compact('rekonKa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RekonKas $rekonKa)
    {
        return view('rekon-kas.edit', compact('rekonKa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RekonKas $rekonKa)
    {
        $validated = $request->validate([
            'rekon_date'       => ['required', 'date'],
            'opening_cash'     => ['required', 'integer', 'min:0'],
            'cash_income'      => ['required', 'integer', 'min:0'],
            'non_cash_income'  => ['nullable', 'integer', 'min:0'],
            'operational_cash' => ['required', 'integer', 'min:0'],
            'actual_cash'      => ['required', 'integer', 'min:0'],
            'notes'            => ['nullable', 'string'],
        ]);

        $validated['non_cash_income'] = $validated['non_cash_income'] ?? 0;

        $rekonKa->update($validated);

        return redirect()
            ->route('rekon-kas.index')
            ->with('success', 'Data rekon kas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekonKas $rekonKa)
    {
        $rekonKa->delete();

        return redirect()
            ->route('rekon-kas.index')
            ->with('success', 'Data rekon kas berhasil dihapus.');
    }
}