<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <?php echo $__env->make('layouts.web.meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php echo $__env->make('layouts.web.favicon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <title>
    <?php if(isset($title)): ?> <?php echo e($title); ?> | <?php else: ?> <?php echo $__env->yieldContent('title', ''); ?> <?php endif; ?> <?php echo e(config('app.title')); ?>

  </title>
  <?php echo $__env->make('layouts.web.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="web <?php echo $bodyClass ?? ''; ?>">
  <?php echo $__env->yieldContent('appBefore'); ?>
  <div id="app" class="web <?php echo e((isset($appClass) ? $appClass : '' )); ?>">
    <?php echo $__env->yieldContent('appContent'); ?>
  </div>
  <?php echo $__env->yieldContent('appAfter'); ?>
  <?php echo $__env->make('layouts.web.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /src/resources/views/layouts/web/base.blade.php ENDPATH**/ ?>