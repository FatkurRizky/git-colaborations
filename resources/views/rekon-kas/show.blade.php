@extends('layouts.app')

@section('content')
    @php
        $statusClass = match($rekonKas->status) {
            'sesuai' => 'bg-green-100 text-green-700 ring-green-200',
            'selisih kurang' => 'bg-red-100 text-red-700 ring-red-200',
            default => 'bg-amber-100 text-amber-700 ring-amber-200',
        };

        $differenceClass = $rekonKas->difference < 0
            ? 'text-red-600'
            : ($rekonKas->difference > 0 ? 'text-amber-600' : 'text-green-600');
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
                <a href="{{ route('rekon-kas.edit', $rekonKas) }}"
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
                    {{ $rekonKas->rekon_date?->format('d-m-Y') }}
                </p>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Status</p>
                <div class="mt-3">
                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold ring-1 {{ $statusClass }}">
                        {{ ucfirst($rekonKas->status) }}
                    </span>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Dibuat Oleh</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ $rekonKas->creator->name ?? '-' }}
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
                            Rp {{ number_format($rekonKas->opening_cash, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Pemasukan Tunai</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKas->cash_income, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Pemasukan Non Tunai</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKas->non_cash_income, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Pengeluaran Operasional</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKas->operational_cash, 0, ',', '.') }}
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
                            Rp {{ number_format($rekonKas->cash_expected, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Kas Aktual</span>
                        <span class="text-base font-semibold text-slate-900">
                            Rp {{ number_format($rekonKas->actual_cash, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4">
                        <span class="text-sm text-slate-500">Selisih</span>
                        <span class="text-base font-bold {{ $differenceClass }}">
                            Rp {{ number_format($rekonKas->difference, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Catatan & Lampiran yang sudah disederhanakan -->
        <div class="mt-6 rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Catatan</h3>
                
                <!-- Tombol kecil muncul di pojok kanan Header jika ada file terlampir -->
                @if($rekonKas->proof_of_expense)
                    <a href="{{ asset('storage/' . $rekonKas->proof_of_expense) }}" target="_blank" 
                       class="inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 hover:bg-blue-100 transition">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                        </svg>
                        Lihat Struk/Nota
                    </a>
                @endif
            </div>

            <div class="px-6 py-4">
                <p class="text-sm leading-6 text-slate-700">
                    {{ $rekonKas->notes ?: 'Tidak ada catatan.' }}
                </p>
            </div>
        </div>
    </div>
@endsection