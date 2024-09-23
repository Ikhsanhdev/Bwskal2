<?php $__env->startSection('content'); ?>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">BERITA</div>
            <div class="side-title">(<?php echo info_paginate($list, "Berita"); ?> <strong><?php echo e($category->name); ?></strong>)</div>
          </div>
          <div class="flex"></div>
          <div class="d-flex align-items-center">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-select','data' => ['name' => 'category','wrapperClass' => 'mb-0','class' => 'rounded-0']]); ?>
<?php $component->withName('ak-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'category','wrapper-class' => 'mb-0','class' => 'rounded-0']); ?>
              <option value="all">Semua Kategori</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($item->slug); ?>" <?php echo e(selected_if(isset($category) && $category->slug == $item->slug)); ?>><?php echo e($item->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <button class="ml-2 btn rounded-0 btn-accent text-dark fw-700 px-4" id="btnFilter">Filter</button>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent">
      <?php if($list && count($list)): ?>
        <div class="row">
          <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6">
              <div class="berita-card <?php echo e($loop->iteration > 2 ? 'mt-md-5' : ''); ?>">
                <div class="cover mini">
                  <a href="<?php echo e(make_post_link($post)); ?>"
                    class="cover-img">
                    <img src="<?php echo e($post->cover_image); ?>">
                  </a>
                  <div class="cover-content pb-4">
                    <div class="kategori-wrap">
                      <a href="<?php echo e(route('post.category', ['slug' => $post->category_slug])); ?>"
                        class="kategori"><?php echo e($post->category_name); ?></a>
                    </div>
                    <a class="title fz-1-25rem"
                      data-maxline="3"
                      href="<?php echo e(make_post_link($post)); ?>"><?php echo e($post->title); ?></a>
                  </div>
                </div>
                <div class="isi text-dark"><?php echo e(\Str::limit(strip_tags($post->content), 280)); ?></div>
                <div class="meta">Dipublikasi oleh <span class="font-weight-600"><?php echo e($post->author); ?></span> pada
                  <?php echo e($post->created_at->isoFormat('DD MMMM YYYY')); ?> | Dilihat <span class="font-weight-600"><?php echo e($post->hit_total); ?></span> kali</div>
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
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pesan-tengah','data' => ['icon' => 'mdi-file-document-edit-outline','title' => 'Data Berita Kosong']]); ?>
<?php $component->withName('pesan-tengah'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['icon' => 'mdi-file-document-edit-outline','title' => 'Data Berita Kosong']); ?>
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
  $(function () {
    $('#btnFilter').on('click', function () {
      let target = <?php echo json_encode(route('post.category', ['slug' => ':slug:']), 512) ?>;
      target = target.replace(/\:slug\:/g, $(`[name="category"]`).val());
      location.href = target;
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/berita.blade.php ENDPATH**/ ?>