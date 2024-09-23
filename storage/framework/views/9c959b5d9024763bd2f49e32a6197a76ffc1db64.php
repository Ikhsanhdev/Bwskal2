<div class="topbar">
  <div class="container flex-column flex-md-row">
    <div class="d-flex align-items-center">
      <i class="mdi mdi-home fz-1-15rem mr-2"></i>
      <a href="https://www.pu.go.id/"
        class="topbar-link"
        target="_blank">PUPR</a>
      <div class="mx-2">|</div>
      <a href="https://sda.pu.go.id/"
        class="topbar-link"
        target="_blank">Ditjen SDA</a>
    </div>
    <div class="flex"></div>
    <div class="d-flex align-items-center">
      <div class="d-flex align-items-center mr-3">
        <i class="mdi mdi-calendar-month fz-1-15rem mr-1"></i>
        <?php echo e(now()->isoFormat('DD MMMM YYYY')); ?>

      </div>
      <ul class="topbar-social">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.web.medsos-link','data' => []]); ?>
<?php $component->withName('web.medsos-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      </ul>
    </div>
  </div>
</div>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/layouts/web/topbar.blade.php ENDPATH**/ ?>