<?php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Halaman';
$formAction = route('admin.page.' . ($isEdit ? 'update' : 'store'));
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
<i class="mdi mdi-file d-none d-md-inline-block mr-3"></i>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-content-title">
  <a href="<?php echo e(route('admin.page.index')); ?>"
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
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Judul Halaman','name' => 'title','placeholder' => 'Masukkan judul halaman','value' => $data->title ?? '','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Judul Halaman','name' => 'title','placeholder' => 'Masukkan judul halaman','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->title ?? ''),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      
      <div class="form-group">
        <label for="">URL Halaman</label>
        <input type="text"
          class="form-control"
          id="iUrl"
          name="url"
          <?php echo e($isEdit && $data->is_custom_slug ? '' : 'readonly'); ?>

          required
          data-parsley-alphadash
          value="<?php echo e($data->slug ?? ''); ?>"
          >
        <div class="ak-checkbox mt-3">
          <input 
            type="checkbox" 
            id="is_custom"
            name="is_custom_slug"
            <?php echo e($isEdit && $data->is_custom_slug ? 'checked' : ''); ?>

            >
          <label for="is_custom" class="cb"></label>
          <label for="is_custom" class="label fz-md">Gunakan custom URL</label>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label"
          for="content">Konten Halaman</label>
        <textarea name="content"
          id="content"
          class="form-control"><?php echo e($data->content ?? ''); ?></textarea>
      </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
      <button class="btn btn-primary"
        type="submit">SIMPAN</button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
<script src="<?php echo e(url('libs/ckeditor/ckeditor.js')); ?>"></script>
<script>
  $(async function () {
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
    let fForm = AKForm.make({});
    $('input[name="title"]').on('keyup', function(){
      if ($('#is_custom').prop('checked'))
        return;
      var $this = $(this);
      var slug = $this.val();
      slug = slug.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-')
        ;
      $('#iUrl').val(slug);
    });
    $('#is_custom').on('change', function(){
      if ($('#is_custom').prop('checked')) {
        $('#iUrl').removeAttr('readonly');
      } else {
        $('#iUrl').attr('readonly', 'readonly');
        $('input[name="title"]').trigger('keyup');
      }
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/page/form.blade.php ENDPATH**/ ?>