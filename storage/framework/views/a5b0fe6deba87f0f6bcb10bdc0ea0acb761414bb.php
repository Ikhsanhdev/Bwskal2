<?php
  $title = 'Pengumuman';
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">PENGUMUMAN</div>
            <div class="side-title">(<?php echo info_paginate($list, 'Pengumuman'); ?>)</div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent">
      <?php if($list && count($list)): ?>
        <div class="row">
          <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6">
              <div class="berita-card <?php echo e($loop->iteration > 2 ? 'mt-md-5' : ''); ?>">
                <div class="cover mini">
                  <a href="<?php echo e(route('pengumuman.detail', ['slug' => $item->slug])); ?>"
                    class="cover-img">
                    <img src="<?php echo e($item->cover_image); ?>">
                  </a>
                  <div class="cover-content pb-4">
                    <a class="title fz-1-25rem"
                      data-maxline="3"
                      href="<?php echo e(route('pengumuman.detail', ['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a>
                  </div>
                </div>
                <div class="meta mt-3">Dipublikasi oleh <span class="font-weight-600"><?php echo e($item->author); ?></span> pada
                  <?php echo e($item->created_at->isoFormat('DD MMMM YYYY')); ?> | Dilihat <span class="font-weight-600"><?php echo e($item->hit); ?></span> kali</div>
              </div>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-bullhorn','title' => 'Data Pengumuman Kosong']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-bullhorn','title' => 'Data Pengumuman Kosong']); ?>
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

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/announcement/index.blade.php ENDPATH**/ ?>