<?php
  $title = 'Galeri ' . ucfirst($type);
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">GALERI</div>
            <div class="side-title">(<?php echo info_paginate($list, "Item"); ?></strong>)</div>
          </div>
          <div class="flex"></div>
          <div class="d-flex align-items-center">
            <?php if($type == 'image'): ?>
            <div class="btn is-btn rounded-0 fw-700 bg-accent px-4 btn-gallery"
              >Foto</div>
            <a class="btn is-btn rounded-0 fw-700 bg-white px-4 btn-gallery"
              href="<?php echo e(route('gallery.index', ['type' => 'video'])); ?>"
              >Video</a>
            <?php else: ?>
            <a class="btn is-btn rounded-0 fw-700 bg-white px-4 btn-gallery"
              href="<?php echo e(route('gallery.index', ['type' => 'image'])); ?>"
              >Foto</a>
            <div class="btn is-btn rounded-0 fw-700 bg-accent px-4 btn-gallery"
              >Video</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent pt-3 pt-md-5">
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
          <div class="d-flex justify-content-center">
            <?php echo e($list->links()); ?>

          </div>
        <?php endif; ?>
      <?php else: ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-file-document-edit-outline','title' => $title . ' Kosong']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-file-document-edit-outline','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title . ' Kosong')]); ?>
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

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/gallery/index.blade.php ENDPATH**/ ?>