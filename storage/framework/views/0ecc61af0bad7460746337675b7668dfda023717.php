<?php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' Unduhan';
  $formAction = route('admin.unduhan.' . ($isEdit ? 'update' : 'store'));
  $formHasFile = true;
?>

<?php $__env->startSection('title'); ?>
  <i class="mdi mdi-file-download mr-2"></i>
  <span class="font-weight-bold"><?php echo e($title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <div class="form-group">
    <label class="control-label"
      for="file">Berkas</label>
    <?php if($isEdit): ?>
      <div class="d-flex justify-content-center align-items-center flex-column flex">
        <i class="mdi mdi-file fz-3-5rem"></i>
        <div class="fz-md font-weight-bold text-center"><?php echo e($data->file); ?></div>
        <div class="mt-2 text-center">
          <a href="#"
            class="btn btn-secondary">UNDUH BERKAS</a>
        </div>
      </div>
    <?php else: ?>
      <div class="d-flex justify-content-center align-items-center flex-column flex">
        <i class="mdi mdi-file fz-3-5rem"></i>
        <div class="fz-1-15rem font-weight-bold text-center"
          id="fFileName">Silakan pilih berkas</div>
        <div class="fz-md text-muted text-center"
          id="fFileSize"><?php echo e('Bertipe ' . \App\Models\Unduhan::getExtensionList()); ?></div>
      </div>
      <div class="form-group">
        <label for=""
          class="d-none"></label>
        <input type="file"
          id="iFile"
          class="vis-hidden"
          name="berkas"
          required>
      </div>
      <div class="btn-list-horizontal mb-md-0 mt-3 mb-3 text-center">
        <button class="btn btn-secondary"
          type="button"
          id="bPilih">Pilih Berkas</button>
      </div>
    <?php endif; ?>
  </div>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'title','placeholder' => 'Judul uduhan','label' => 'Judul Unduhan','value' => $data->title ?? '','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'title','placeholder' => 'Judul uduhan','label' => 'Judul Unduhan','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->title ?? ''),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-select','data' => ['name' => 'category','label' => 'Kategori','list' => $kategoriList,'placeholder' => 'Pilih Kategori','value' => $data->category_id ?? '','required' => true]]); ?>
<?php $component->withName('ak-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'category','label' => 'Kategori','list' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kategoriList),'placeholder' => 'Pilih Kategori','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->category_id ?? ''),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <div class="ak-checkbox">
    <input 
      type="checkbox" 
      id="is_private"
      name="is_private"
      <?php echo checked_if($isEdit && $data->is_private); ?>>
    <label for="is_private" class="cb"></label>
    <label for="is_private" class="label ">Batasi akses berkas</label>
  </div>
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
      <?php if(!$isEdit): ?>
        let fd = {
          name: `Silakan pilih berkas`,
          size: `<?php echo e('Bertipe ' . \App\Models\Unduhan::getExtensionList()); ?>`,
        };
        let fFileName = $('#fFileName');
        let fFileSize = $('#fFileSize');
        let fPilih = $('#bPilih');
        let fFile = $('#iFile');
        fPilih.on('click', () => fFile.click());
        fFile.on('change', (e) => {
          let t = e.target;
          if (t.files.length) {
            let ff = t.files[0];
            fFileName.html(ff.name);
            fFileSize.html(formatByte(ff.size));
          } else {
            fFileName.html(fd.name);
            fFileSize.html(fd.size);
            fFile.val('');
          }
        });
      <?php endif; ?>

      let fForm = AKForm.make({
        datatables: dTables,
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/unduhan/modal-form.blade.php ENDPATH**/ ?>