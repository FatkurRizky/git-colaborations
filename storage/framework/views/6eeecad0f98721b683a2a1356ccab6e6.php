<?php $__env->startSection('content'); ?>
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Tambah Rekon Kas</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Isi form berikut untuk menambahkan data rekon kas baru.
                </p>
            </div>

            <a href="<?php echo e(route('rekon-kas.index')); ?>"
               class="inline-flex items-center rounded-lg bg-slate-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-slate-700">
                Kembali
            </a>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="border-b border-slate-200 px-6 py-4">
                <h3 class="text-lg font-semibold text-slate-900">Form Tambah Rekon</h3>
                <p class="mt-1 text-sm text-slate-500">
                    Pastikan data yang diinput sesuai dengan kondisi kas aktual.
                </p>
            </div>

            <form action="<?php echo e(route('rekon-kas.store')); ?>" method="POST" enctype="multipart/form-data" class="px-6 py-6">
                <?php echo csrf_field(); ?>

                <?php echo $__env->make('rekon-kas.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-200 pt-6">
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                        Simpan Data
                    </button>

                    <a href="<?php echo e(route('rekon-kas.index')); ?>"
                       class="inline-flex items-center rounded-lg bg-slate-500 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-slate-600">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/muhammad/Kalkulator_rekon/resources/views/rekon-kas/create.blade.php ENDPATH**/ ?>