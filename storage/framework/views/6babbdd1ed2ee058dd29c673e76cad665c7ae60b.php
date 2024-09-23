<?php
  $title = 'Pegawai';
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-uppercase">
              <div class="text-uppercase">PEGAWAI</div>
            </div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">

          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent page-text-content">
      <?php if(isset($list) && count($list)): ?>
        <div class="row web-pegawai-wrap">
          <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-3 pegawai-col">
              <div class="pegawai-item"
                data-id="<?php echo e(encrypt($item->id)); ?>"
                >
                <div class="foto">
                  <img src="<?php echo e($item->foto_image); ?>">
                </div>
                <div class="name"><?php echo e($item->name); ?></div>
                <div class="position"><?php echo e($item->position); ?></div>
                <div class="__overlay">
                  <div class="btn btn-light fw-800">LIHAT DETAIL</div>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php else: ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-card-account-details','title' => 'Data Pegawai Kosong']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-card-account-details','title' => 'Data Pegawai Kosong']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfter'); ?>
<script>
  $(document).ready(function () {
    $('.pegawai-item').on('click', function () {
      AKModal.open({
        url: `<?php echo e(route('web.pegawai.detail')); ?>`,
        data: {
          id: this.dataset.id,
        }
      });
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/pegawai/index.blade.php ENDPATH**/ ?>