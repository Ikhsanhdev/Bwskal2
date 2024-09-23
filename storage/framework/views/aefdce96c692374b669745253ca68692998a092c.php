<?php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Berita';
if ($isEdit && $data->status == 'draft') {
  $title = 'Ubah Draft Berita';
}
$formAction = route('admin.post.' . ($isEdit ? 'update' : 'store'));
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.cropit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-newspaper-variant d-none d-md-inline-block mr-3"></i>
  Berita
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  
  <div class="admin-content-title">
    <a href="<?php echo e(route('admin.post.index')); ?>"
      class="btn btn-icon text-primary px-2">
      <i class="mdi mdi-arrow-left-thick fz-lg"></i>
    </a>
    <div class="font-weight-bold fz-normal ml-2"><?php echo e($title); ?></div>
  </div>

  
  <div class="admin-section">
    <form action="<?php echo e($formAction); ?>"
      class="card"
      method="POST"
      id="formnya">
      <?php if($isEdit): ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden"
          name="_id"
          value="<?php echo e($data->id); ?>" />
      <?php endif; ?>
      <div class="card-body">
        <div class="form-group">
          <label class="control-label mb-0"
            for="cover">Sampul <span class="fz-md font-weight-normal">(Opsional, Minimal berukuran 900px x 450px)</span></label>
          <div id="ciCover"
            class="ak-cropit"
            data-name="cover"></div>
        </div>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Judul','name' => 'title','placeholder' => 'Masukkan judul berita','value' => $data->title ?? '','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Judul','name' => 'title','placeholder' => 'Masukkan judul berita','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->title ?? ''),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-select','data' => ['name' => 'category','label' => 'Kategori Berita','list' => $kategoriList,'placeholder' => 'Pilih Kategori Berita','value' => $data->category_id ?? '','required' => true]]); ?>
<?php $component->withName('ak-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'category','label' => 'Kategori Berita','list' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kategoriList),'placeholder' => 'Pilih Kategori Berita','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->category_id ?? ''),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="form-group">
          <label class="control-label"
            for="content">Konten Berita</label>
          <textarea name="content"
            id="content"
            class="form-control"><?php echo e($data->content ?? ''); ?></textarea>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-end btn-list-horizontal">
        <?php if(!$isEdit || ($isEdit && $data->status == 'draft')): ?>
        <button class="btn btn-secondary"
          type="submit" name="save_status" value="draft">SIMPAN DRAFT</button>
        <button class="btn btn-primary"
          type="submit" name="save_status">PUBLISH</button>
        <?php else: ?>
        <button class="btn btn-primary"
          type="submit" name="save_status">SIMPAN</button>
        <?php endif; ?>
      </div>
    </form>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
<script src="<?php echo e(url('libs/ckeditor/ckeditor.js')); ?>"></script>
<script>
  $(async function() {
    <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>
    let topViewport = document.querySelector('.admin-header').offsetHeight + 40;
    let editorOptions = {
      ui: {
        viewportOffset: {
          top: topViewport,
        }
      },
    };
    let contentEditor = await AKCKEditorMake(document.querySelector('#content'), editorOptions);

    window.ciCover = new AKCropit('#ciCover', {
      width: 900,
      height: 450,
      teksPilih: 'Pilih',
      responsive: {
        xs: .3,
        sm: .5,
        md: .75,
        lg: .75,
        xl: .75
      },
      cropit: {
        smallImage: 'allow',
        <?php if($isEdit && $data->cover): ?>
          imageState: {
            src: '<?php echo e(url($data->cover_image)); ?>'
          },
        <?php endif; ?>
      },
    });

    AKForm.make({
      dataBuilder(data) {
        data.forEach(d => {
          if (d.type == "file" && d.name == "cover" && d.value != "") {
            d.value = ciCover.export();
          }
        });
        return data;
      },
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/post/form.blade.php ENDPATH**/ ?>