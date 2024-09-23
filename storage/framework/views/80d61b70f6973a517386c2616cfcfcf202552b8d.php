<?php $__env->startSection('appContent'); ?>

<div class="admin-container-single">
  <?php echo $__env->yieldContent('content'); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/layouts/admin/single.blade.php ENDPATH**/ ?>