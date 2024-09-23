<?php $attributes = $attributes->exceptProps([
  'name',
  'label',
  'list' => [],
  'class' => '',
  'wrapperClass' => '',
  'placeholder' => null,
  'id' => null,
  'required' => false,
  'value' => null,
  'sublabel' => null,
  'sublabelPosition' => 'top',
]); ?>
<?php foreach (array_filter(([
  'name',
  'label',
  'list' => [],
  'class' => '',
  'wrapperClass' => '',
  'placeholder' => null,
  'id' => null,
  'required' => false,
  'value' => null,
  'sublabel' => null,
  'sublabelPosition' => 'top',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="form-group <?php echo e($wrapperClass); ?>">
  <?php if(isset($label)): ?>
  <label for="" class="<?php echo e(isset($sublabel) && $sublabelPosition == 'top' ? 'mb-0' : ''); ?>"><?php echo e($label); ?></label>
  <?php endif; ?>
  <?php if(isset($sublabel) && $sublabelPosition == 'top'): ?>
  <div class="text-muted mb-2 fz-0-8rem"><?php echo $sublabel; ?></div>
  <?php endif; ?>
  <select 
    <?php if($id): ?>
    id="<?php echo $id; ?>"
    <?php endif; ?>
    name="<?php echo e($name); ?>"
    class="form-control <?php echo e($class); ?>"
    <?php if($required): ?>
    required
    <?php endif; ?>
    <?php echo e($attributes); ?>

    >
    <?php if($placeholder): ?>
    <option value=""><?php echo e($placeholder); ?></option>
    <?php endif; ?>
    <?php if($list && count($list)): ?>
    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $itemvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($key); ?>" <?php echo e(selected_if(isset($value) && $value == $key)); ?>><?php echo e($itemvalue); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php elseif($slot->isNotEmpty()): ?>
      <?php echo e($slot); ?>

    <?php endif; ?>
  </select>
  <?php if(isset($sublabel) && $sublabelPosition == 'bottom'): ?>
  <div class="text-muted mb-2 mt-2 fz-0-8rem"><?php echo $sublabel; ?></div>
  <?php endif; ?>
</div>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/components/ak-select.blade.php ENDPATH**/ ?>