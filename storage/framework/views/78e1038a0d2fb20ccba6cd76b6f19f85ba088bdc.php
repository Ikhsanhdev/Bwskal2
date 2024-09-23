<?php
  $title = $data->title;
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-uppercase"><?php echo e($data->title); ?></div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
            Diperbaharui pada <span class="fw-700"><?php echo e($data->updated_at->isoFormat('DD MMMM YYYY')); ?></span> | Dilihat <span class="fw-700"><?php echo e($data->hit); ?></span> kali
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent page-text-content ck-content">
      <?php echo $data->content; ?>

    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/halaman.blade.php ENDPATH**/ ?>