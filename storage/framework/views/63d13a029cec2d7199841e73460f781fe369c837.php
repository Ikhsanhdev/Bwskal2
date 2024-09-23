<?php
  $title = 'Menu';
?>

<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-form-dropdown d-none d-md-inline-block mr-3"></i>
  <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-section" id="menuApp-AKsc">
  <menu-app />
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsBeforeMain'); ?>
<script>
  window.urllist = {
    menu: `<?php echo e(route('admin.menu.update')); ?>`,
  };
  window.menu_init_data = {
    list: <?php echo json_encode($menulist->menulist); ?>,
    default: <?php echo json_encode($defaultmenu->default_list); ?>,
  };
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/menu/index.blade.php ENDPATH**/ ?>