<div class="ig-feed h-100">
  <div class="ig-feed-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <i class="mdi mdi-instagram fz-2-5rem mr-2"></i>
      <div class="lh-1">
        <div class="fz-1-15rem fw-700 mb-1"><?php echo e('@' . $username); ?></div>
        <div class="fz-0-75rem text-muted"><?php echo e($mediaTotal); ?> media</div>
      </div>
    </div>
    <a class="btn btn-accent fw-600"
      href="https://www.instagram.com/<?php echo e($username); ?>"
      target="_blank">Follow</a>
  </div>
  <div class="ig-feed-content mt-3">
    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e($item->link); ?>"
        class="ig-feed-item"
        target="_blank">
        <img src="<?php echo e(url('uploads/ig/' . $item->image)); ?>"
          class="ig-feed-img">
        <div class="ig-feed-caption">
          <div class="content"><?php echo e($item->caption); ?></div>
        </div>
        <?php switch($item->type):
          case ('IMAGE'): ?>
            <i class="mdi mdi-image ig-feed-icon"></i>
          <?php break; ?>

          <?php case ('VIDEO'): ?>
            <i class="mdi mdi-video ig-feed-icon"></i>
          <?php break; ?>

          <?php case ('CAROUSEL_ALBUM'): ?>
            <i class="mdi mdi-camera-burst ig-feed-icon"></i>
          <?php break; ?>
        <?php endswitch; ?>
      </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/templates/ig-feed.blade.php ENDPATH**/ ?>