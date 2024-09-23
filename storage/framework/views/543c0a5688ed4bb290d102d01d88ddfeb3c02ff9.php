<?php $attributes = $attributes->exceptProps([
  'label',
  'value' => null,
  'class' => '',
  ]); ?>
<?php foreach (array_filter(([
  'label',
  'value' => null,
  'class' => '',
  ]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="form-group">
  <?php if(isset($label)): ?>
  <label for=""><?php echo e($label); ?></label>
  <?php endif; ?>
  <div
    class="form-control h-auto <?php echo $class; ?>"
    <?php echo e($attributes); ?>

    >
    <?php echo e($value ?? ''); ?>

    </div>
</div><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/components/ak-text.blade.php ENDPATH**/ ?>