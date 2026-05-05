<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? 'Auth'); ?> - <?php echo e(config('app.name', 'Kalkulator Rekon')); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <?php echo e($slot); ?>

</body>
</html><?php /**PATH /home/muhammad/Kalkulator_rekon/resources/views/components/layouts/auth.blade.php ENDPATH**/ ?>