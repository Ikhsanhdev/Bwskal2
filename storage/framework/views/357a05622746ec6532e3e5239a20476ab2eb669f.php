<?php
  $title = 'Kontak WA';
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.cropit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-whatsapp d-none d-md-inline-block mr-3"></i>
  <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  
  <div class="admin-section">
    <form class="card"
      id="formnya"
      method="POST"
      action="<?php echo e(route('admin.kontak-wa.update')); ?>">
      <?php echo method_field('PUT'); ?>
      <div class="card-body">
        <div class="font-weight-bold fz-lg text-dark">Pengaturan Tombol Kontak WA</div>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'telepon','label' => 'Nomor Telepon Tujuan','placeholder' => '$label','value' => $data->telepon ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'telepon','label' => 'Nomor Telepon Tujuan','placeholder' => '$label','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->telepon ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <hr class="mt-4">
        
        <div class="font-weight-bold fz-lg text-dark">Pengaturan Popup Kontak WA</div>
        <div class="alert alert-warning d-flex mt-2">
          <i class="mdi mdi-information fz-2rem mr-3"></i>
          <div>
            <div class="fw-700">Harap diperhatikan!</div>
            <div class="fz-0-85rem">Foto, nama dan isi pesan <strong>wajib</strong> diisi jika ingin memunculkan popup.</div>
          </div>
        </div>
        <div class="form-group">
          <label for="">Foto <span class="fz-0-75rem text-muted fw-600">(Opsional)</span></label>
          <div id="ciPhoto"
            class="ak-cropit"
            data-name="foto"></div>
        </div>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'nama','label' => 'Nama','placeholder' => '$label','optional' => true,'value' => $data->nama ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'nama','label' => 'Nama','placeholder' => '$label','optional' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->nama ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'keterangan','label' => 'Keterangan','placeholder' => '$label','optional' => true,'value' => $data->keterangan ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'keterangan','label' => 'Keterangan','placeholder' => '$label','optional' => true,'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->keterangan ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="form-group">
          <label class="control-label"
            for="pesan">Isi Pesan <span class="fz-0-75rem text-muted fw-600">(Opsional)</span></label>
          <textarea name="pesan"
            id="pesan"
            class="form-control"><?php echo e($data->pesan ?? ''); ?></textarea>
        </div>
        
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary text-uppercase fz-1rem"
          type="submit">SIMPAN</button>
      </div>
    </form>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
  <script src="<?php echo e(url('libs/ckeditor/ckeditor.js')); ?>"></script>
  <script>
    $(function() {
      <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>

      setTimeout(async () => {
        let topViewport = document.querySelector('.admin-header').offsetHeight + 40;
        let editorOptions = {
          ui: {
            viewportOffset: {
              top: topViewport,
            }
          },
        };
        let contentEditor = await AKCKEditorMake(document.querySelector('#pesan'), editorOptions);
        let cropper = new AKCropit('#ciPhoto', {
          width: 100,
          height: 100,
          teksPilih: 'Pilih Foto',
          cropit: {
            imageState: {
              <?php if($data->foto): ?>
                src: <?php echo json_encode(url('uploads/avatar/' . $data->foto), 15, 512) ?>,
              <?php endif; ?>
            },
            smallImage: "allow",
          },
        });
        AKForm.make({
          indicator: {
            overlay: true
          },
          dataBuilder: (data) => {
            data.forEach(d => {
              if (d.type == "file" && d.name == "foto") {
                if (d.value) {
                  d.value = cropper.export();
                }
              }
            });
            return data;
          },
        });
      }, 700);
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/kontak-wa/index.blade.php ENDPATH**/ ?>