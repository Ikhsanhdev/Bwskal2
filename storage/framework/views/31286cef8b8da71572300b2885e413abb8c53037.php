<?php
  $title = $album->name . " (Album)";
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">ALBUM</div>
            <?php if(count($list)): ?>
            <div class="side-title">(<?php echo info_paginate($list, "Item"); ?></strong>)</div>
            <?php endif; ?>
          </div>
          <div class="flex"></div>
          <div class="d-flex align-items-center">
            <a class="btn is-btn rounded-0 fw-700 bg-white px-4 btn-gallery"
              href="<?php echo e(route('gallery.index', ['type' => 'image'])); ?>"
              >KE GALERI FOTO</a>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent">
      <div class="text-center font-weight-bold fz-1-5rem"><?php echo e($album->name); ?></div>
      <?php if($album->description): ?>
      <div><?php echo e($album->description); ?></div>
      <?php endif; ?>
      <hr>
      <?php if($list && count($list)): ?>
        <div class="row">
          <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-3">
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.web.gallery-item','data' => ['item' => $item]]); ?>
<?php $component->withName('web.gallery-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['item' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if(isset($list) && $list->total() > $list->perPage()): ?>
          <div class="mt-md-5 d-flex justify-content-center mt-3">
            <?php echo e($list->links()); ?>

          </div>
        <?php endif; ?>
      <?php else: ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-image-multiple','title' => 'Album Kosong','subtitle' => 'Album ini masih belum memiliki data']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-image-multiple','title' => 'Album Kosong','subtitle' => 'Album ini masih belum memiliki data']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
<script>
  $(document).ready(function () {
    window.gb = GLightbox({
      elements: [],
    });
    $('.gc-item').on('click', function (e) {
      e.preventDefault();
      let gdata = {
        judul: this.dataset.judul,
        keterangan: this.dataset.keterangan ?? '',
        waktu: this.dataset.waktu ?? '',
      };
      gb.settings.slideHTML = `<div class="gslide">
    <div class="gslide-inner-content">
        <div class="ginner-container">
            <div class="gslide-media">
              <div class="gslide-captionnya">
                <div class="title">${gdata.judul}</div>
                ${gdata.keterangan? '<div class="keterangan">' + gdata.keterangan+ '</div>' : ''}
                ${gdata.waktu ? '<div class="waktu">' + gdata.waktu + '</div>' : ''}
              </div>
            </div>
        </div>
    </div>
</div>`;
      gb.setElements([{ href: this.href }]);
      gb.open();
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/gallery/album.blade.php ENDPATH**/ ?>