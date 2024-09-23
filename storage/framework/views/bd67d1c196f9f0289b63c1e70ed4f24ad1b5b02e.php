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
            <div class="title"><?php echo e($title); ?></div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">

          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent pb-4">
      <div class="row">
        <div class="col-12 col-md-4 d-flex">
          <div class="d-flex flex justify-content-center align-items-center flex-column">
            <i class="fi <?php echo flaticon_from_mime($unduhan->mime); ?> fz-5rem"></i>
            <div class="fw-800 fz-1-25rem text-center"><?php echo e($unduhan->title); ?></div>
            <div class="text-muted fz-0-85rem text-center">Diunduh <?php echo e($unduhan->hit); ?> kali</div>
          </div>
        </div>
        <div class="col-12 d-md-none">
          <hr>
        </div>
        <div class="col-12 col-md-8">
          <form id="request-form"
            action="<?php echo e(route('direktori.request', request()->route()->parameters)); ?>"
            method="POST"
            >
            <?php echo csrf_field(); ?>
            <div class="fw-800 fz-1-25rem">Form Permohonan Akses</div>
            <div class="mb-3 text-secondary">Anda memerlukan izin untuk mengakses dokumen ini, silakan lengkapi form berikut.</div>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'name','label' => 'Nama Lengkap','placeholder' => '$label','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'name','label' => 'Nama Lengkap','placeholder' => '$label','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['type' => 'email','name' => 'email','label' => 'Email Aktif','placeholder' => '$label','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'email','name' => 'email','label' => 'Email Aktif','placeholder' => '$label','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['type' => 'textarea','name' => 'message','label' => 'Tujuan/ Keperluan Permintaan Dokumen','placeholder' => '$label','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'textarea','name' => 'message','label' => 'Tujuan/ Keperluan Permintaan Dokumen','placeholder' => '$label','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

            <div class="d-flex justify-content-end">
              <?php echo NoCaptcha::displaySubmit('request-form', 'Minta Akses', [
                'class' => 'btn btn-primary fw-700"',
                'data-callback' => 'onSubmitformnya',
              ]); ?>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('cssAfter'); ?>
<?php echo NoCaptcha::renderJs(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
<script>
  $(function () {
    <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>

    window.fform = AKForm.make({
      el: '#request-form',
      indicator: {overlay: true},
    });
    
    window.onSubmitformnya = function () {
      fform.submit();
    }
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/direktori/request.blade.php ENDPATH**/ ?>