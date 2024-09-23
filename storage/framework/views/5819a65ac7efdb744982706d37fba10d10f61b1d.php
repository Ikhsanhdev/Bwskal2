<script>
  window.baseurl = `<?php echo e(url('')); ?>`;
</script>

<?php echo $__env->yieldContent('jsBefore'); ?>
<script src="<?php echo e(url('libs/jquery.min.js')); ?>"></script>
<script src="<?php echo e(url('libs/smartmenus/jquery.smartmenus.min.js')); ?>"></script>
<script src="<?php echo e(url('libs/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.js')); ?>"></script>
<script src="<?php echo e(url('libs/line-height.js')); ?>"></script>
<script src="<?php echo e(url('libs/jquery.lazy.min.js')); ?>"></script>
<script src="<?php echo e(url('libs/better-scroll/bscroll.min.js')); ?>"></script>
<script src="//cdn.jsdelivr.net/npm/glightbox@3.0.7/dist/js/glightbox.min.js"></script>

<?php echo $__env->yieldContent('jsBeforeMain'); ?>
<script src="<?php echo e(url('libs/aklibs/aklibs.min.js')); ?>"></script>
<script src="<?php echo e(mix('assets/js/web.js')); ?>"></script>

<?php echo $__env->yieldContent('jsAfterMain'); ?>
<?php echo $__env->yieldContent('jsAfter'); ?>
<?php /**PATH /src/resources/views/layouts/web/script.blade.php ENDPATH**/ ?>