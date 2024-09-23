<div class="akbox">
  <div class="content <?php echo e(isset($padding) ? $padding : 'p-5'); ?> d-flex flex-column text-center text-dark">
    <div class="mb-3">
      <i class="mdi <?php echo e(isset($icon) ? $icon : 'mdi-cloud-off-outline'); ?> fz-5rem"></i>
    </div>
    <div class="fz-xl fw-700"><?php echo e($title); ?></div>
    <?php if(isset($subtitle)): ?>
    <div class="fz-normal"><?php echo $subtitle; ?></div>
    <?php endif; ?>
  </div>
</div>
<?php /**PATH /src/resources/views/components/pesan-tengah.blade.php ENDPATH**/ ?>