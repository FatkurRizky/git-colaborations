@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-slate-900">Data Rekon Kas</h2>
        <a href="{{ route('rekon-kas.create') }}"
           class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700">
            + Tambah Rekon
        </a>
    </div>

    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <form method="GET" action="{{ route('rekon-kas.index') }}">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label for="start_date" class="mb-1 block text-sm font-medium text-slate-700">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label for="end_date" class="mb-1 block text-sm font-medium text-slate-700">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" id="status"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Semua Status --</option>
                        <option value="sesuai" {{ request('status') == 'sesuai' ? 'selected' : '' }}>Sesuai</option>
                        <option value="selisih kurang" {{ request('status') == 'selisih kurang' ? 'selected' : '' }}>Selisih Kurang</option>
                        <option value="selisih lebih" {{ request('status') == 'selisih lebih' ? 'selected' : '' }}>Selisih Lebih</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                <button type="submit"
                        class="rounded-lg bg-cyan-600 px-4 py-2 text-sm font-medium text-white hover:bg-cyan-700">
                    Filter
                </button>
                <a href="{{ route('rekon-kas.index') }}"
                   class="rounded-lg bg-slate-500 px-4 py-2 text-sm font-medium text-white hover:bg-slate-600">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        @if($rekons->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Saldo Awal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Pemasukan Tunai</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Operasional</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Kas Seharusnya</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Kas Aktual</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Selisih</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Dibuat Oleh</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($rekons as $index => $rekon)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm">{{ $rekons->firstItem() + $index }}</td>
                                <td class="px-4 py-3 text-sm">{{ $rekon->rekon_date?->format('d-m-Y') }}</td>
                                <td class="px-4 py-3 text-sm">Rp {{ number_format($rekon->opening_cash, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm">Rp {{ number_format($rekon->cash_income, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm">Rp {{ number_format($rekon->operational_cash, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm">Rp {{ number_format($rekon->cash_expected, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm">Rp {{ number_format($rekon->actual_cash, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm font-semibold {{ $rekon->difference < 0 ? 'text-red-600' : ($rekon->difference > 0 ? 'text-amber-600' : 'text-green-600') }}">
                                    Rp {{ number_format($rekon->difference, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($rekon->status === 'sesuai')
                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Sesuai</span>
                                    @elseif($rekon->status === 'selisih kurang')
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Selisih Kurang</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Selisih Lebih</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $rekon->creator->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('rekon-kas.show', $rekon->id) }}"
                                           class="rounded-lg bg-cyan-600 px-3 py-2 text-xs font-medium text-white hover:bg-cyan-700">Detail</a>
                                        <a href="{{ route('rekon-kas.edit', $rekon->id) }}"
                                           class="rounded-lg bg-amber-500 px-3 py-2 text-xs font-medium text-white hover:bg-amber-600">Edit</a>
                                        <form action="{{ route('rekon-kas.destroy', $rekon->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($rekons->hasPages())
                <div class="border-t border-slate-200 px-4 py-4">
                    {{ $rekons->links() }}
                </div>
            @endif
        @else
            <div class="px-4 py-6 text-sm text-slate-500">
                Belum ada data rekon kas.
            </div>
        @endif
    </div>
@endsection