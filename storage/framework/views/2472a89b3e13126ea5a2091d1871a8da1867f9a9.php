<?php
  $title = 'Agenda';
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">AGENDA</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent pb-4">
      <?php if(isset($list) && count($list)): ?>
      <div class="table-responsive">
        <table class="table-agenda table-bordered table-hover table">
          <thead>
            <tr>
              <th class="text-center">NO.</th>
              <th class="text-center" style="min-width: 300px">AGENDA</th>
              <th class="text-center">LAMPIRAN</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="agenda-item"
                id="agenda-<?php echo e($item->slug); ?>">
                <td>
                  <div class="fw-800 fz-1-25rem text-center"><?php echo e($loop->iteration); ?></div>
                </td>
                <td>
                  <div class="d-flex align-items-center mb-1" style="gap: .75rem">
                    <div class="agenda-info">
                      <i class="mdi icon mdi-calendar"></i>
                      <div class="kata"><?php echo e($item->date_range_text); ?></div>
                    </div>
                    <div class="agenda-info">
                      <i class="mdi icon mdi-map-marker"></i>
                      <div class="kata"><?php echo e($item->location); ?></div>
                    </div>
                  </div>
                  <div class="title"><?php echo e($item->title); ?></div>
                  <div class="fz-0-8rem text-dark"><?php echo $item->description; ?></div>
                </td>
                <td class="text-center">
                  <?php if($item->attachment): ?>
                    <a href="<?php echo e($item->attachment_url); ?>"
                      class="btn btn-outline-primary wide"
                      target="_blank">UNDUH</a>
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-calendar-clock','title' => 'AGENDA KOSONG','subtitle' => 'Data Agenda belum ada']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-calendar-clock','title' => 'AGENDA KOSONG','subtitle' => 'Data Agenda belum ada']); ?>
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

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/agenda.blade.php ENDPATH**/ ?>