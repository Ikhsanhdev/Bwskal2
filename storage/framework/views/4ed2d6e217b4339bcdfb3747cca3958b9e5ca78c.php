<?php $attributes = $attributes->exceptProps([
  'label',
  'color' => 'bg-white',
  'value' => '',
  'icon' => null,
  ]); ?>
<?php foreach (array_filter(([
  'label',
  'color' => 'bg-white',
  'value' => '',
  'icon' => null,
  ]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
switch ($color) {
  case 'bg-primary':
    $colorClass = 'bg-primary text-white';
    break;

  default:
    $colorClass = 'bg-white';
    break;
}
?>

<div class="card <?php echo e($colorClass); ?> mb-3">
  <div class="card-body">
    <div class="d-flex no-block align-items-center">
      <div>
        <h6><?php echo e($label); ?></h6>
        <h2 class="m-0 font-weight-bold"><?php echo e($value); ?></h2>
      </div>
      <?php if($icon): ?>
      <div class="ml-auto">
        <span class=" display-6"><i class="mdi <?php echo e($icon); ?> fz-2-5rem"></i></span>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/components/dashboard-card.blade.php ENDPATH**/ ?>