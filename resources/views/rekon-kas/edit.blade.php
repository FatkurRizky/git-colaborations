@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Edit Rekon Kas</h2>
                <p class="mt-2 text-sm text-slate-500">
                    Perbarui data rekon untuk tanggal
                    <span class="font-semibold text-slate-700">
                        {{ $rekonKas->rekon_date?->format('d-m-Y') }}
                    </span>
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('rekon-kas.show', $rekonKas->id) }}"
                   class="inline-flex items-center rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-amber-600">
                    Lihat Detail
                </a>
                <a href="{{ route('rekon-kas.index') }}"
                   class="inline-flex items-center rounded-xl bg-slate-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-slate-700">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
                        <h3 class="text-lg font-semibold text-slate-900">Form Edit Rekon</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Pastikan nominal yang diubah sudah sesuai dengan data kas aktual.
                        </p>
                    </div>

                    <form action="{{ route('rekon-kas.update', $rekonKas->id) }}" method="POST" enctype="multipart/form-data" class="px-6 py-6">
                        @csrf
                        @method('PUT')

                        @include('rekon-kas.form', ['rekonKas' => $rekonKas, 'mode' => 'edit'])

                        <div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6">
                            <button type="submit"
                                    class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                Update Data
                            </button>

                            <a href="{{ route('rekon-kas.show', $rekonKas->id) }}"
                               class="inline-flex items-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">
                                Lihat Detail
                            </a>

                            <a href="{{ route('rekon-kas.index') }}"
                               class="inline-flex items-center rounded-xl bg-slate-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-600">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <h3 class="text-base font-semibold text-slate-900">Info Data</h3>
                    <dl class="mt-4 space-y-4">
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Tanggal</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-800">
                                {{ $rekonKas->rekon_date?->format('d-m-Y') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Status Saat Ini</dt>
                            <dd class="mt-1">
                                @if($rekonKas->status === 'sesuai')
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Sesuai
                                    </span>
                                @elseif($rekonKas->status === 'selisih kurang')
                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Selisih Kurang
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                        Selisih Lebih
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Dibuat Oleh</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-800">
                                {{ $rekonKas->creator->name ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-slate-50 p-6 ring-1 ring-blue-100">
                    <h3 class="text-base font-semibold text-slate-900">Catatan</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li>• Pemasukan non tunai hanya untuk catatan, tidak masuk kas fisik.</li>
                        <li>• Selisih akan dihitung otomatis saat data diperbarui.</li>
                        <li>• Pastikan kas aktual sesuai uang fisik yang benar-benar tersedia.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection