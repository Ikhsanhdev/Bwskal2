<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>
    <?php if(isset($title)): ?> <?php echo e($title); ?> | <?php else: ?> <?php echo $__env->yieldContent('title', ''); ?> <?php endif; ?> <?php echo e(config('app.title')); ?>

  </title>
  <?php echo $__env->make('layouts.admin.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="admin <?php echo $bodyClass ?? ''; ?>">
  <?php echo $__env->yieldContent('appBefore'); ?>
  <div id="app" class="admin <?php echo e((isset($appClass) ? $appClass : '' )); ?>">
    <?php echo $__env->yieldContent('appContent'); ?>
  </div>
  <?php echo $__env->yieldContent('appAfter'); ?>
  <script>
    window.baseurl = `<?php echo e(url('')); ?>`;
  </script>
  <?php echo $__env->make('layouts.admin.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/layouts/admin/base.blade.php ENDPATH**/ ?>