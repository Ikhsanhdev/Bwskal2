<?php
  $isEdit = false;
  $title = 'Tambah item Album';
  $formAction = route('admin.gallery.store');
  $formHasFile = true;
?>

<?php $__env->startSection('title'); ?>
  <i class="mdi mdi-image-album mr-2"></i>
  <span class="font-weight-bold"><?php echo e($title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <input type="hidden"
    name="album"
    value="<?php echo e($album->id); ?>" />
  <input type="hidden"
    name="type"
    value="image" />
  <div class="form-group">
    <label class="control-label mb-0"
      for="gambar">Gambar</label>
    <div class="fz-md text-muted">Gambar akan disimpan sesuai ukuran asli</div>
    <div id="ciGambar"
      class="ak-cropit"
      data-name="content"></div>
  </div>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Judul','placeholder' => '$label','name' => 'name','vModel' => 'formdata.name','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Judul','placeholder' => '$label','name' => 'name','v-model' => 'formdata.name','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['type' => 'textarea','label' => 'Keterangan','placeholder' => '$label','name' => 'description','optional' => true,'vModel' => 'formdata.description']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'textarea','label' => 'Keterangan','placeholder' => '$label','name' => 'description','optional' => true,'v-model' => 'formdata.description']); ?>
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
  <button class="btn btn-block btn-primary m-0">SIMPAN</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script>
    $(document).ready(function() {
      window.gApp = new Vue({
        el: '#formnya',
        data: () => {
          return {
            imgPreview: '',
            gambar: null,
            form: null,
            formdata: {}
          };
        },
        methods: {
          init() {
            this.form = new AKForm("#formnya", {
              form: {
                beforeSubmit: (data) => {
                  let fiGambar = data.find(item => item.name == 'content' && item.type == 'file');
                  if (fiGambar && fiGambar.value != "") {
                    data.push({
                      name: 'thumb',
                      value: this.gambar.export()
                    });
                  }
                  tInfo = AKToast.info({
                    message: 'Sedang menyimpan',
                    icon: 'mdi mdi-send-circle'
                  }, false);
                },
                success: (res) => {
                  tInfo.close();
                  this.form.reset();
                  if (res.success) {
                    AKToast.success(res.message);
                    this.form.closeModal();
                    window.galeriApp.reload();
                  }
                },
                error: (xhr) => {
                  var res = AKForm.parseXhr(xhr);
                  tInfo.close();
                  AKToast.error(res.pesanToast);
                  this.form.parseError(xhr);
                }
              }
            });
            this.gambar = new AKCropit('#ciGambar', {
              width: 250,
              height: 250,
              teksPilih: 'Pilih Gambar',
              cropit: {
                smallImage: 'stretch',
              },
            });
          },
        },
        mounted() {
          this.init();
        }
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/gallery/modal-form-album.blade.php ENDPATH**/ ?>