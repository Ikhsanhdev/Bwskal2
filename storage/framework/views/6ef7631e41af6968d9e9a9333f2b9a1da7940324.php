<?php $__env->startSection('cssBeforeMain'); ?>
  <link href="//cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
  <?php echo \Illuminate\View\Factory::parentPlaceholder('cssBeforeMain'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsBeforeMain'); ?>
  <script src="//cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="//cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.min.js"></script>
  <script>
    flatpickr.localize(flatpickr.l10ns.id);
  </script>
  <?php echo \Illuminate\View\Factory::parentPlaceholder('jsBeforeMain'); ?>
<?php $__env->stopSection(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/libs/flatpickr.blade.php ENDPATH**/ ?>