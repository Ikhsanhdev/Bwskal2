<?php
  $title = 'Form Permohonan Akses Dokumen';
?>

<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-center text-md-left lh-1"><?php echo e($title); ?></div>
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent py-5 text-center">
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-email-check','padding' => 'p-md-5','title' => 'Permintaan Akses Terkirim','subtitle' => 'Akses akan diberikan setelah permintaan dikonfirmasi oleh Administrator yang bersangkutan,<br>silakan cek email Anda secara berkala untuk informasi lebih lanjut.']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-email-check','padding' => 'p-md-5','title' => 'Permintaan Akses Terkirim','subtitle' => 'Akses akan diberikan setelah permintaan dikonfirmasi oleh Administrator yang bersangkutan,<br>silakan cek email Anda secara berkala untuk informasi lebih lanjut.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <a href="<?php echo e(route('direktori.index')); ?>" class="btn btn-primary fw-700 mt-3 mt-md-0">KEMBALI KE DIREKTORI</a>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
  <script>
    $(function() {
      <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/direktori/request-sent.blade.php ENDPATH**/ ?>