<?php $attributes = $attributes->exceptProps([
  'name',
  'label',
  'placeholder',
  'data',
  'id' => null,
  'class' => '',
  'type' => 'text',
  'required' => false,
  'value' => null,
  'sublabel' => null,
  'sublabelPosition' => 'top',
  'autocomplete' => 'off',
  'optional' => false,
  ]); ?>
<?php foreach (array_filter(([
  'name',
  'label',
  'placeholder',
  'data',
  'id' => null,
  'class' => '',
  'type' => 'text',
  'required' => false,
  'value' => null,
  'sublabel' => null,
  'sublabelPosition' => 'top',
  'autocomplete' => 'off',
  'optional' => false,
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
  <label for="" class="<?php echo e(isset($sublabel) && $sublabelPosition == 'top' ? 'mb-0' : ''); ?>"><?php echo $label; ?> <?php echo $optional ? '<span class="fz-0-75rem text-muted fw-600">(Opsional)</span>' : ''; ?></label>
  <?php endif; ?>
  <?php if(isset($sublabel) && $sublabelPosition == 'top'): ?>
  <div class="text-muted mb-2 fz-0-8rem"><?php echo $sublabel; ?></div>
  <?php endif; ?>
  <?php if($type == 'textarea'): ?>
  <textarea
    <?php if($id): ?>
    id="<?php echo $id; ?>"
    <?php endif; ?>
    name="<?php echo e($name); ?>"
    type="<?php echo $type; ?>"
    class="form-control <?php echo e($class); ?>"
    placeholder="<?php echo e(isset($placeholder) ? ($placeholder == '$label' && isset($label) ? $label : $placeholder) : Str::title($name)); ?>"
    <?php if($required): ?>
    required
    <?php endif; ?>
    <?php echo e($attributes); ?>

    ><?php if(isset($data) && !isset($value) && isset($data->{$name})): ?><?php echo e($data->{$name}); ?><?php else: ?><?php echo e($value ?? ''); ?><?php endif; ?></textarea>
  <?php else: ?>
  <input
    <?php if($id): ?>
    id="<?php echo $id; ?>"
    <?php endif; ?>
    name="<?php echo e($name); ?>"
    type="<?php echo $type; ?>"
    class="form-control <?php echo e($class); ?>"
    autocomplete="<?php echo e($autocomplete); ?>"
    placeholder="<?php echo e(isset($placeholder) ? ($placeholder == '$label' && isset($label) ? $label : $placeholder) : Str::title($name)); ?>"
    <?php if($required): ?>
    required
    <?php endif; ?>
    <?php echo e($attributes); ?>

    <?php if(isset($data) && !isset($value) && isset($data->{$name})): ?>
    value="<?php echo e($data->{$name}); ?>"
    <?php else: ?>
    value="<?php echo e($value ?? ''); ?>"
    <?php endif; ?>
    >
  <?php endif; ?>
  <?php if(isset($sublabel) && $sublabelPosition == 'bottom'): ?>
  <div class="text-muted mb-2 mt-2 fz-0-8rem"><?php echo $sublabel; ?></div>
  <?php endif; ?>
</div>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/components/ak-input.blade.php ENDPATH**/ ?>