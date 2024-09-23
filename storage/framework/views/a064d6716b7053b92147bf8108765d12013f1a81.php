<?php
  $title = 'Direktori';
?>

<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">DIREKTORI</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem">
            <?php echo info_paginate($list, "Berkas", $dataFiltered); ?> | Dilihat <strong><?php echo e(Visitor::countRoute('direktori.index')); ?></strong> kali
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box decor-bt-accent pb-4">
      <form class="unduhan-filter"
        method="GET">
        <input type="text"
          class="form-control rounded-0 bg-light border-0 px-3"
          placeholder="cari judul berkas..."
          name="q"
          value="<?php echo e(isset($filterQuery['q']) ? $filterQuery['q'] : ''); ?>"
          >
        <select name="kategori"
          class="form-control rounded-0 bg-light border-0">
          <option value="all">Semua Kategori</option>
          <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($kategori->id); ?>"
            <?php echo e(selected_if(isset($filterQuery['kategori']) && $filterQuery['kategori'] == $kategori->id)); ?>><?php echo e($kategori->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn rounded-0 btn-accent text-dark fw-700 px-4">Cari</button>
      </form>

      <hr class="mt-0 d-md-none">

      <?php if(isset($list) && count($list)): ?>
        <div class="unduhan-list">
          <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item">
              <i class="fi <?php echo flaticon_from_mime($item->mime); ?> icon"></i>
              <div class="tulisan">
                <div class="nama"><?php echo e($item->title); ?></div>
                <div class="meta">
                  <a class="kategori"
                    href="#"><?php echo e($item->kategori_name); ?></a>
                  <div class="info">Diterbitkan <?php echo e($item->created_at->isoFormat('DD MMMM YYYY')); ?> | Diunduh <?php echo e($item->hit); ?>

                    kali</div>
                </div>
              </div>
              <?php if($item->is_private): ?>
              <a class="btn btn-unduh btn-primary-alt"
                href="<?php echo e(route('direktori.download', ['slug' => $item->slug])); ?>"
                target="_blank">
                <i class="mdi mdi-lock mr-2"></i>
                <span>Minta Akses</span>
              </a>
              <?php else: ?>
              <a class="btn btn-unduh btn-primary-alt"
                href="<?php echo e(route('direktori.download', ['slug' => $item->slug])); ?>"
                target="_blank">Unduh</a>
              <?php endif; ?>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(isset($list) && $list->total() > $list->perPage()): ?>
        <div class="mt-5 d-flex justify-content-center">
          <?php if(count($filterQuery) > 0): ?>
          <?php echo e($list->appends($filterQuery)->links()); ?>

          <?php else: ?>
          <?php echo e($list->links()); ?>

          <?php endif; ?>
        </div>
        <?php endif; ?>
      <?php else: ?>
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-folder-download','title' => 'DIREKTORI KOSONG','subtitle' => $dataFiltered ? 'Pencarian tidak ditemukan' : 'Data unduhan belum tersedia']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-folder-download','title' => 'DIREKTORI KOSONG','subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dataFiltered ? 'Pencarian tidak ditemukan' : 'Data unduhan belum tersedia')]); ?>
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

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/direktori/index.blade.php ENDPATH**/ ?>