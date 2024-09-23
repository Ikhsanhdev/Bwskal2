<?php echo $__env->yieldContent('jsBefore'); ?>
<script src="<?php echo e(url('libs/jquery.min.js')); ?>"></script>
<script src="<?php echo e(url('libs/line-height.js')); ?>"></script>
<script src="<?php echo e(url('libs/jquery.lazy.min.js')); ?>"></script>
<script src="<?php echo e(url('libs/better-scroll/bscroll.min.js')); ?>"></script>
<script src="//cdn.jsdelivr.net/npm/glightbox@3.0.7/dist/js/glightbox.min.js"></script>

<?php echo $__env->yieldContent('jsBeforeMain'); ?>
<script src="<?php echo e(url('libs/aklibs/aklibs.min.js')); ?>"></script>
<script src="<?php echo e(mix('assets/js/app.js')); ?>"></script>

<?php echo $__env->yieldContent('jsAfterMain'); ?>
<?php echo $__env->yieldContent('jsAfter'); ?>
<script>
</script><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/layouts/admin/js.blade.php ENDPATH**/ ?>