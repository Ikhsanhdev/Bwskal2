<?php $attributes = $attributes->exceptProps(['item']); ?>
<?php foreach (array_filter((['item']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
  $_uploadPath = \App\Models\Gallery::UPLOAD_PATH;
?>

<?php switch($item->type):
  case ('album'): ?>
    <a class="galeri-card mb-4 mb-lg-5 d-block is-album"
      href="<?php echo route('gallery.album', ['slug' => $item->slug]); ?>">
      <?php if($item->content): ?>
      <img
        src="<?php echo e(url($_uploadPath . 'thumbs_' . $item->content)); ?>"
        class="galeri-thumbs">
      <?php else: ?>
      <div class="galeri-thumbs d-flex justify-content-center align-items-center">
        <i class="mdi mdi-image-album fz-4rem"></i>
      </div>
      <?php endif; ?>
      <div class="album-badge">
        <i class="mdi mdi-image-multiple"></i>
      </div>
      <div class="content-wrap">
        <div class="judul"
          data-maxline="3"><?php echo e($item->name); ?></div>
      </div>
    </a>
  <?php break; ?>
  
  <?php case ('image'): ?>
  <a class="galeri-card gc-item mb-4 mb-lg-5 d-block"
    href="<?php echo e(url($_uploadPath . $item->content)); ?>"
    data-judul="<?php echo e($item->name); ?>"
    data-keterangan="<?php echo e($item->description); ?>"
    data-waktu="<?php echo e($item->created_at->isoFormat('DD MMMM YYYY')); ?>"
    >
    <img
      src="<?php echo e($item->thumbs_image); ?>"
      class="galeri-thumbs">
    <div class="content-wrap">
      <div class="judul"
        data-maxline="3"><?php echo e($item->name); ?></div>
    </div>
  </a>
  <?php break; ?>

  <?php case ('video'): ?>
  <a class="galeri-card gc-item mb-4 mb-lg-5 d-block"
    href="<?php echo e('https://www.youtube.com/watch?v=' . $item->content); ?>"
    data-judul="<?php echo e($item->name); ?>"
    data-keterangan="<?php echo e($item->description); ?>"
    data-waktu="<?php echo e($item->created_at->isoFormat('DD MMMM YYYY')); ?>"
    >
    <img
      src="<?php echo e($item->thumbs_image); ?>"
      class="galeri-thumbs">
    <div class="album-badge">
      <i class="mdi mdi-video"></i>
    </div>
    <div class="content-wrap">
      <div class="judul"
        data-maxline="3"><?php echo e($item->name); ?></div>
    </div>
  </a>
  <?php break; ?>
<?php endswitch; ?>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/components/web/gallery-item.blade.php ENDPATH**/ ?>