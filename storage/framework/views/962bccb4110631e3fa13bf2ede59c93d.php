<?php $__env->startSection('content'); ?>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-2xl font-bold text-slate-900">Data Rekon Kas</h2>
        
        <div class="flex flex-wrap gap-2">
            <a href="<?php echo e(route('rekon-kas.create')); ?>"
               class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700">
                + Tambah Rekon
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-800 ring-1 ring-green-200">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 ring-1 ring-red-200">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <form method="GET" action="<?php echo e(route('rekon-kas.index')); ?>">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label for="start_date" class="mb-1 block text-sm font-medium text-slate-700">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="<?php echo e(request('start_date')); ?>"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label for="end_date" class="mb-1 block text-sm font-medium text-slate-700">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="<?php echo e(request('end_date')); ?>"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" id="status"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Semua Status --</option>
                        <option value="sesuai" <?php echo e(request('status') == 'sesuai' ? 'selected' : ''); ?>>Sesuai</option>
                        <option value="selisih kurang" <?php echo e(request('status') == 'selisih kurang' ? 'selected' : ''); ?>>Selisih Kurang</option>
                        <option value="selisih lebih" <?php echo e(request('status') == 'selisih lebih' ? 'selected' : ''); ?>>Selisih Lebih</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                <button type="submit"
                        class="rounded-lg bg-cyan-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-cyan-700">
                    Filter
                </button>
                <a href="<?php echo e(route('rekon-kas.index')); ?>"
                   class="rounded-lg bg-slate-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-slate-600">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <?php if($rekons->count()): ?>
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
                        <?php $__currentLoopData = $rekons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $rekon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                // Kalkulasi Kas Seharusnya (jaga-jaga jika tidak ada di database)
                                $calculated_expected = ($rekon->opening_cash + $rekon->cash_income) - $rekon->operational_cash;
                            ?>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-sm"><?php echo e($rekons->firstItem() + $index); ?></td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($rekon->rekon_date)->format('d-m-Y')); ?></td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">Rp <?php echo e(number_format($rekon->opening_cash, 0, ',', '.')); ?></td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">Rp <?php echo e(number_format($rekon->cash_income, 0, ',', '.')); ?></td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">Rp <?php echo e(number_format($rekon->operational_cash, 0, ',', '.')); ?></td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">Rp <?php echo e(number_format($rekon->cash_expected ?? $calculated_expected, 0, ',', '.')); ?></td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">Rp <?php echo e(number_format($rekon->actual_cash, 0, ',', '.')); ?></td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap font-semibold <?php echo e($rekon->difference < 0 ? 'text-red-600' : ($rekon->difference > 0 ? 'text-amber-600' : 'text-green-600')); ?>">
                                    Rp <?php echo e(number_format($rekon->difference, 0, ',', '.')); ?>

                                </td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <?php if($rekon->status === 'sesuai'): ?>
                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Sesuai</span>
                                    <?php elseif($rekon->status === 'selisih kurang'): ?>
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Selisih Kurang</span>
                                    <?php else: ?>
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Selisih Lebih</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap"><?php echo e($rekon->creator->name ?? '-'); ?></td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="<?php echo e(route('rekon-kas.show', $rekon->id)); ?>"
                                           class="rounded-lg bg-cyan-600 px-3 py-2 text-xs font-medium text-white hover:bg-cyan-700">Detail</a>
                                        <a href="<?php echo e(route('rekon-kas.edit', $rekon->id)); ?>"
                                           class="rounded-lg bg-amber-500 px-3 py-2 text-xs font-medium text-white hover:bg-amber-600">Edit</a>
                                        
                                        <form action="<?php echo e(route('rekon-kas.destroy', $rekon->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($rekons->hasPages()): ?>
                <div class="border-t border-slate-200 px-4 py-4">
                    <?php echo e($rekons->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="px-4 py-12 text-center">
                <p class="text-sm text-slate-500">Belum ada data rekon kas yang sesuai pencarian.</p>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/muhammad/Kalkulator_rekon/resources/views/rekon-kas/index.blade.php ENDPATH**/ ?>