<?php
  $title = 'Pencarian "' . request()->query('q') . '"';
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title text-uppercase">
              <div class="text-uppercase">HASIL PENCARIAN</div>
              <div class="font-weight-normal fz-0-85rem"
                data-maxline="1">
                "<?php echo e(request()->query('q')); ?>"
              </div>
            </div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
            <?php echo info_paginate($list, "Hasil"); ?>

          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent page-text-content">
      <?php if($list && count($list)): ?>
      <ul class="list-group">
        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-group-item list-group-item-action">
          <a 
            href="<?php echo e(make_post_link($item)); ?>"
            class="d-flex align-items-center no-line">
            <div class="tulisan flex">
              <div class="text-primary fz-0-8rem">
                <?php echo e($item->created_at->isoFormat('DD MMMM YYYY')); ?>

              </div>
              <div class="text-dark2 font-weight-600 fz-1-15rem mb-1"><?php echo e($item->title); ?></div>
              <div class="text-muted fz-0-8rem"><?php echo Str::limit((strip_tags($item->content)), 250); ?></div>
            </div>
            <div class="icon ml-3">
              <i class="mdi mdi-newspaper-variant-outline text-dark fz-2-15rem"></i>
            </div>
          </a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
      <?php if(isset($list) && $list->total() > $list->perPage()): ?>
      <div class="mt-5 d-flex justify-content-center">
        <?php echo e($list->links()); ?>

      </div>
      <?php endif; ?>
      <?php else: ?>
        <?php
        $subtitle = 'Tidak ada hasil yang cocok untuk "' . request()->query('q') . '"';
        ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-text-box-search','title' => 'Pencarian Tidak Ditemukan','subtitle' => $subtitle]]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-text-box-search','title' => 'Pencarian Tidak Ditemukan','subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($subtitle)]); ?>
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

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /src/resources/views/web/pencarian.blade.php ENDPATH**/ ?>