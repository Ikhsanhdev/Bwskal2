<?php
$title = 'Pengaturan Situs';
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-application-cog-outline d-none d-md-inline-block mr-3"></i>
  <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  
  <div class="admin-section">
    <div class="font-weight-bold text-dark fz-lg mb-3">Pilih Menu Pengaturan</div>
    <div class="row">
      <div class="col-2 as-col">
        <a class="as-item" href="<?php echo e(route('admin.pengaturan-situs.page', ['page' => 'informasi'])); ?>">
          <div class="icon">
            <img src="<?php echo e(url('assets/images/icon/2039835.svg')); ?>" class="img-fluid">
          </div>
          <div class="label">Informasi</div>
        </a>
      </div>
      <div class="col-2 as-col">
        <a class="as-item" href="<?php echo e(route('admin.pengaturan-situs.page', ['page' => 'media-sosial'])); ?>">
          <div class="icon">
            <img src="<?php echo e(url('assets/images/icon/4187272.svg')); ?>" class="img-fluid">
          </div>
          <div class="label">Media Sosial</div>
        </a>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/pengaturan-situs/index.blade.php ENDPATH**/ ?>