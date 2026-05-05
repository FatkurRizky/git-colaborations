@php
    $isEdit = isset($rekonKa);
    $mode = $mode ?? 'create';
@endphp

<div class="space-y-8">
    <!-- Informasi Utama -->
    <div>
        <div class="mb-4">
            <h4 class="text-base font-semibold text-slate-900">Informasi Utama</h4>
            <p class="text-sm text-slate-500">Lengkapi data dasar rekon kas pada bagian ini.</p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="rekon_date" class="mb-2 block text-sm font-medium text-slate-700">
                    Tanggal Rekon
                </label>
                <input
                    type="date"
                    name="rekon_date"
                    id="rekon_date"
                    value="{{ old('rekon_date', $isEdit && $rekonKa->rekon_date ? $rekonKa->rekon_date->format('Y-m-d') : '') }}"
                    required
                    class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
                @error('rekon_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="opening_cash" class="mb-2 block text-sm font-medium text-slate-700">
                    Saldo Awal
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-slate-500">Rp</span>
                    <input
                        type="number"
                        name="opening_cash"
                        id="opening_cash"
                        value="{{ old('opening_cash', $isEdit ? $rekonKa->opening_cash : '') }}"
                        placeholder="0"
                        onfocus="this.select()"
                        min="0"
                        step="1"
                        required
                        class="block w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>
                @error('opening_cash')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Pergerakan Kas -->
    <div>
        <div class="mb-4">
            <h4 class="text-base font-semibold text-slate-900">Pergerakan Kas</h4>
            <p class="text-sm text-slate-500">Masukkan pemasukan dan pengeluaran yang memengaruhi kas.</p>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="cash_income" class="mb-2 block text-sm font-medium text-slate-700">
                    Pemasukan Tunai
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-slate-500">Rp</span>
                    <input
                        type="number"
                        name="cash_income"
                        id="cash_income"
                        value="{{ old('cash_income', $isEdit ? $rekonKa->cash_income : '') }}"
                        placeholder="0"
                        onfocus="this.select()"
                        min="0"
                        step="1"
                        required
                        class="block w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>
                @error('cash_income')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="non_cash_income" class="mb-2 block text-sm font-medium text-slate-700">
                    Pemasukan Non Tunai
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-slate-500">Rp</span>
                    <input
                        type="number"
                        name="non_cash_income"
                        id="non_cash_income"
                        value="{{ old('non_cash_income', $isEdit ? $rekonKa->non_cash_income : '') }}"
                        placeholder="0"
                        onfocus="this.select()"
                        min="0"
                        step="1"
                        class="block w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>
                <p class="mt-2 text-xs leading-5 text-slate-500">
                    Nilai ini hanya untuk catatan pendapatan, tidak dihitung ke kas fisik.
                </p>
                @error('non_cash_income')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="operational_cash" class="mb-2 block text-sm font-medium text-slate-700">
                    Pengeluaran Operasional
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-slate-500">Rp</span>
                    <input
                        type="number"
                        name="operational_cash"
                        id="operational_cash"
                        value="{{ old('operational_cash', $isEdit ? $rekonKa->operational_cash : '') }}"
                        placeholder="0"
                        onfocus="this.select()"
                        min="0"
                        step="1"
                        required
                        class="block w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>
                @error('operational_cash')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="actual_cash" class="mb-2 block text-sm font-medium text-slate-700">
                    Kas Aktual / Uang Fisik
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-slate-500">Rp</span>
                    <input
                        type="number"
                        name="actual_cash"
                        id="actual_cash"
                        value="{{ old('actual_cash', $isEdit ? $rekonKa->actual_cash : '') }}"
                        placeholder="0"
                        onfocus="this.select()"
                        min="0"
                        step="1"
                        required
                        class="block w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                </div>
                @error('actual_cash')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- BUKTI PENDUKUNG (Upload Nota) -->
    <div>
        <div class="mb-4">
            <h4 class="text-base font-semibold text-slate-900">Bukti Pendukung</h4>
            <p class="text-sm text-slate-500">Upload foto nota/struk pengeluaran operasional (opsional).</p>
        </div>

        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6">
            <label for="proof_of_expense" class="block text-sm font-medium text-slate-700 mb-2">
                Pilih File Bukti
            </label>
            <input 
                type="file" 
                name="proof_of_expense" 
                id="proof_of_expense" 
                accept="image/jpeg,image/png,image/jpg,application/pdf"
                class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 outline-none transition"
            >
            <p class="mt-2 text-xs text-slate-500">Format: JPG, PNG, atau PDF. Maksimal 2MB.</p>
            
            @error('proof_of_expense')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if($isEdit && !empty($rekonKa->proof_of_expense))
                <div class="mt-4 flex items-center gap-2 text-sm text-slate-700 bg-white p-3 border border-slate-200 rounded-lg inline-block">
                    <span>File saat ini:</span>
                    <a href="{{ asset('storage/' . $rekonKa->proof_of_expense) }}" target="_blank" class="font-medium text-blue-600 hover:underline">
                        Lihat Bukti
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Catatan Tambahan -->
    <div>
        <div class="mb-4">
            <h4 class="text-base font-semibold text-slate-900">Catatan Tambahan</h4>
            <p class="text-sm text-slate-500">Tambahkan keterangan jika ada hal yang perlu dicatat.</p>
        </div>

        <div>
            <label for="notes" class="mb-2 block text-sm font-medium text-slate-700">
                Catatan
            </label>
            <textarea
                name="notes"
                id="notes"
                rows="5"
                class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                placeholder="Tulis catatan tambahan di sini..."
            >{{ old('notes', $isEdit ? $rekonKa->notes : '') }}</textarea>
            @error('notes')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>