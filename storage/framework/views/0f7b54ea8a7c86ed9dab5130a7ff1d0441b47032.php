<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title"><?php echo e($title); ?></div>
          </div>
          <div class="flex"></div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent">
      <div class="lh-1 mb-4 text-center d-flex flex-column align-items-center justify-content-center" style="height: 50vh">
        <i class="mdi <?php echo e($icon ?? 'mdi-human-dolly'); ?> fz-6rem d-block my-4"></i>
        <div class="text-dark font-weight-bold ff-baloo2 fz-1-5rem text-uppercase"><?php echo $message; ?></div>
        <?php if(isset($submessage)): ?>
        <div class="fz-0-8rem mt-1 fw-600"><?php echo $submessage; ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/errors/web.blade.php ENDPATH**/ ?>