<?php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' Link';
  
  $formHasFile = true;
  $formAction = route('admin.link-terkait.' . ($isEdit ? 'update' : 'store'));
?>

<?php $__env->startSection('title'); ?>
  <i class="mdi mdi-link mr-2"></i>
  <span class="font-weight-bold"><?php echo e($title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <div class="form-group">
    <label class="control-label mb-0"
      for="logo">Logo</label>
    <div class="fz-0-8rem text-muted font-weight-normal">Berukuran 400px x 200px</div>
    <div id="ciLogo"
      class="ak-cropit"
      data-name="logo"></div>
  </div>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Nama Link','name' => 'name','placeholder' => '$label','required' => true,'value' => $data->name ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Nama Link','name' => 'name','placeholder' => '$label','required' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->name ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Link Tujuan','name' => 'link','placeholder' => '$label','required' => true,'value' => $data->link ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Link Tujuan','name' => 'link','placeholder' => '$label','required' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->link ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

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
      let ciLogo = new AKCropit('#ciLogo', {
        width: 400,
        height: 200,
        teksPilih: 'Pilih',
        cropit: {
          smallImage: 'allow',
          <?php if($isEdit && $data->image): ?>
          imageState: {
            src: `<?php echo e(url(\App\Models\LinkTerkait::UPLOAD_PATH . $data->image)); ?>`,
          },
          <?php endif; ?>
        },
      })

      AKForm.make({
        datatables: window.listApp,
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

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/link-terkait/modal-form.blade.php ENDPATH**/ ?>