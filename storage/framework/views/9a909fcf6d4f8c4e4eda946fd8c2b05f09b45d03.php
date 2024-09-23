<?php
  $title = $data->title;
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">DETAIL BERITA</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem text-center text-md-left d-flex flex-column flex-md-row">
            <div>
              Diterbitkan oleh <span class="fw-700"><?php echo e($data->author); ?></span> pada <span class="fw-700"><?php echo e($data->created_at->isoFormat('DD MMMM YYYY')); ?></span>
            </div>
            <div class="d-none d-md-block px-1">|</div>
            <div>Dilihat <?php echo e($data->hit_total); ?> kali</div>
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box px-0 pt-0">
      <div class="web-post-cover">
        <img src="<?php echo e($data->cover_image); ?>"
          class="web-post-cover-img">
        <div class="web-post-cover-content">
          <div class="kategori-wrap">
            <a href="<?php echo e(route('post.category', ['slug' => $data->category_slug])); ?>"
              class="kategori"><?php echo e($data->category_name); ?></a>
          </div>
          <div class="title"
            data-maxline="5"><?php echo e($data->title); ?></div>
        </div>
      </div>
      <div class="page-text-content ck-content">
        <?php echo $data->content; ?>

      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/berita-detail.blade.php ENDPATH**/ ?>