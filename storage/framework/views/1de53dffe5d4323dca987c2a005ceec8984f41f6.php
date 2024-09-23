<?php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' FAQ';
  
  $formHasFile = true;
  $formAction = route('admin.faq.' . ($isEdit ? 'update' : 'store'));
?>

<?php $__env->startSection('title'); ?>
  <i class="mdi mdi-message-question mr-2"></i>
  <span class="font-weight-bold"><?php echo e($title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Pertanyaan','name' => 'title','placeholder' => '$label','required' => true,'value' => $data->title ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Pertanyaan','name' => 'title','placeholder' => '$label','required' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->title ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <div class="form-group">
    <label class="control-label"
      for="content">Jawaban</label>
    <textarea name="content"
      id="content"
      class="form-control"><?php echo e($data->content ?? ''); ?></textarea>
  </div>

  <div class="ak-checkbox mt-3">
    <input 
      type="checkbox" 
      id="is_show"
      name="is_show"
      <?php echo e($isEdit && !$data->is_show ? '' : 'checked'); ?>

      >
    <label for="is_show" class="cb"></label>
    <label for="is_show" class="label">Tampilkan pada halaman publik</label>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button type="submit"
    class="btn btn-block btn-primary m-0"
    >SIMPAN</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script>
    $(function() {
      let contentEditor = AKCKEditorMake(document.querySelector('#content'));

      AKForm.make({
        datatables: window.faqApp,
        indicator: {
          overlay: true,
        },
        dataBuilder(data) {
          data.forEach(d => {
            if (d.type == "file" && d.name == "logo" && d.value != "") {
              d.value = ciLogo.export();
            }
          });
          return data;
        },
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/faq/modal-form.blade.php ENDPATH**/ ?>