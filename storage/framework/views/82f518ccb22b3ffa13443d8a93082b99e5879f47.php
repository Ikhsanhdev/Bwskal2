<?php
  $title = 'Frequently Asked Questions (FAQ)';
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title"><?php echo e($title); ?></div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
            <?php if($lastUpdate): ?>
            Diperbaharui <strong><?php echo e($lastUpdate); ?></strong> |
            <?php endif; ?>
            Dilihat <strong><?php echo e(Visitor::countRoute('web.faq')); ?></strong> kali
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent pb-4">
      <?php if($faqs && count($faqs)): ?>
      <div class="text-center fz-1-25rem mb-5 fw-800 text-dark">Beberapa Pertanyaan yang Sering Diajukan Kepada Kami</div>
      <div class="faq-list" style="min-height: 30vh">
        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="faq-item">
          <div class="faq-title" data-toggle="collapse" data-target="#collapse-<?php echo $item->slug; ?>"><?php echo e($item->title); ?></div>
          <div class="faq-content-wrap collapse" id="collapse-<?php echo $item->slug; ?>">
            <div class="faq-content mt-3 ck-content"><?php echo $item->content; ?></div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <?php else: ?>
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-message-question','title' => 'Data FAQ kosong','subtitle' => 'Data item FAQ belum tersedia']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-message-question','title' => 'Data FAQ kosong','subtitle' => 'Data item FAQ belum tersedia']); ?>
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

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/faq.blade.php ENDPATH**/ ?>