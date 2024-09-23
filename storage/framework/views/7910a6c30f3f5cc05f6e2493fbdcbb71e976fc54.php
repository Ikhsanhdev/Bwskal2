<?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li>
  <a
    href="<?php echo e($item->link); ?>"
    target="_blank"
    title="<?php echo e($item->name); ?>"
    class="medsos-link <?php echo e($item->type); ?>">
    <i class="mdi <?php echo e(get_medsos_icon($item->type)); ?>"></i>
  </a>
</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/templates/medsos.blade.php ENDPATH**/ ?>