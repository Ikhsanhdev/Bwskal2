<?php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' Poster';
  $formAction = route('admin.poster.' . ($isEdit ? 'update' : 'store'));
  $formHasFile = true;
?>

<?php $__env->startSection('title'); ?>
  <i class="mdi mdi-tooltip-image mr-2"></i>
  <span class="font-weight-bold"><?php echo e($title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'name','placeholder' => 'Nama poster','label' => 'Nama Poster','value' => $data->name ?? '','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'name','placeholder' => 'Nama poster','label' => 'Nama Poster','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->name ?? ''),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <?php if($isEdit): ?>
    <div class="form-group">
      <label for="">Preview Gambar</label>
      <div class="px-5">
        <img src="<?php echo e(url(\App\Models\Infografis::UPLOAD_PATH . 'preview_' . $data->path)); ?>"
          class="img-fluid rounded">
      </div>
    </div>
    <div class="form-group">
      <label for="">File Gambar <span class="fz-md text-muted font-weight-normal">(Pilih file jika ingin mengganti)</span></label>
      <input type="file"
        name="image"
        class="form-control-file"
        id="image-file"
        >
    </div>
  <?php else: ?>
    <div class="form-group">
      <label for="">File Gambar</label>
      <input type="file"
        name="image"
        class="form-control-file"
        id="image-file"
        required>
    </div>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0">SIMPAN</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script>
    $(document).ready(function() {
      $('#image-file').filestyle();
      let fForm = AKForm.make({
        datatables: dTables,
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/infografis/modal-form.blade.php ENDPATH**/ ?>