@extends('layouts.app')

@section('content')
    @php
        $statusClass = match($rekonKa->status) {
            'sesuai' => 'bg-green-100 text-green-700 ring-green-200',
            'selisih kurang' => 'bg-red-100 text-red-700 ring-red-200',
            default => 'bg-amber-100 text-amber-700 ring-amber-200',
        };

        $differenceClass = $rekonKa->difference < 0
            ? 'text-red-600'
            : ($rekonKa->difference > 0 ? 'text-amber-600' : 'text-green-600');
    @endphp

    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Detail Rekon Kas</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Informasi lengkap data rekon kas harian.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('rekon-kas.edit', $rekonKa->id) }}"
                   class="inline-flex items-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-amber-600">
                    Edit
                </a>

                <a href="{{ route('rekon-kas.index') }}"
                   class="inline-flex items-center rounded-lg bg-slate-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-slate-700">
                    Kembali
                </a>
            </div>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Tanggal Rekon</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ $rekonKa->rekon_date?->format('d-m-Y') }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Status</p>
                <div class="mt-3">
                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold ring-1 {{ $statusClass }}">
                        {{ ucfirst($rekonKa->status) }}
                    </span>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Dibuat Oleh</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ $rekonKa->creator->name ?? '-' }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-slate-900">Ringkasan Keuangan</h3>
                </div>

                <div class="divide-y divide-slate-100">
                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Saldo Awal</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKa->opening_cash, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Pemasukan Tunai</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKa->cash_income, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Pemasukan Non Tunai</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKa->non_cash_income, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Pengeluaran Operasional</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKa->operational_cash, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-slate-900">Hasil Rekonsiliasi</h3>
                </div>

                <div class="divide-y divide-slate-100">
                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Kas Seharusnya</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKa->cash_expected, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Kas Aktual</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKa->actual_cash, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Selisih</span>
                        <span class="text-base font-bold {{ $differenceClass }}">
                            Rp {{ number_format($rekonKa->difference, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-slate-900">Catatan</h3>
            </div>

            <div class="px-6 py-4">
                <p class="text-sm leading-6 text-slate-700">
                    {{ $rekonKa->notes ?: 'Tidak ada catatan.' }}
                </p>
            </div>
        </div>
    </div>
@endsection