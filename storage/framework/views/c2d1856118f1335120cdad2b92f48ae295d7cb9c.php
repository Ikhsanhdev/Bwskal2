<?php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Pengguna';

$formId = 'userForm';
$formAction = route('admin.user.' . ($isEdit ? 'update' : 'store'));
?>

<?php $__env->startSection('title'); ?>
<div class="d-flex align-items-center">
  <i class="mdi mdi-account-group mr-3 <?php echo e($isEdit ? 'fz-2rem' : ''); ?>"></i>
  <div class="lh-1">
    <div class="font-weight-bold"><?php echo e($title); ?></div>
    <?php if($isEdit): ?>
    <div class="badge badge-primary fz-0-75rem mt-1"><?php echo e($data->role_kata); ?></div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <div class="row flex-lg-row-reverse">
    <div class="col-lg-4">
      <div class="form-group">
        <label class="control-label mb-0"
          for="photo">Foto</label>
        <div class="fz-0-8rem text-muted font-weight-normal">Minimal 300px x 300px</div>
        <div id="ciPhoto"
          class="ak-cropit"
          data-name="photo"></div>
      </div>
    </div>
    <div class="col-lg-8">
      <h5 class="text-dark font-weight-bold">Informasi Pengguna</h5>
      <?php if(!$isEdit): ?>
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-select','data' => ['name' => 'role','label' => 'Jenis Pengguna','placeholder' => 'Pilih jenis pengguna','vModel' => 'data.role','required' => true,'list' => $roleList]]); ?>
<?php $component->withName('ak-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'role','label' => 'Jenis Pengguna','placeholder' => 'Pilih jenis pengguna','v-model' => 'data.role','required' => true,'list' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($roleList)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      <?php endif; ?>

      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Nama Lengkap','name' => 'nama','required' => true,'vModel' => 'data.nama']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Nama Lengkap','name' => 'nama','required' => true,'v-model' => 'data.nama']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Alamat Email','name' => 'email','required' => true,'vModel' => 'data.email']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Alamat Email','name' => 'email','required' => true,'v-model' => 'data.email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Nama Pengguna','name' => 'username','required' => true,'vModel' => 'data.username']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Nama Pengguna','name' => 'username','required' => true,'v-model' => 'data.username']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-select','data' => ['name' => 'status','label' => 'Status Akun','placeholder' => 'Pilih Status Akun','vModel' => 'data.status','required' => true,'list' => App\Models\User::getStatusList()]]); ?>
<?php $component->withName('ak-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'status','label' => 'Status Akun','placeholder' => 'Pilih Status Akun','v-model' => 'data.status','required' => true,'list' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(App\Models\User::getStatusList())]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

      <h5 class="text-dark font-weight-bold">Kata Sandi
        <?php if($isEdit): ?>
        <span class="font-weight-normal fz-md">(Isi Jika ingin mengganti kata sandi)</span>
        <?php endif; ?>
      </h5>
      <div class="row">
        <div class="col-md-6">
          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Kata Sandi','name' => 'sandi','type' => 'password','placeholder' => '$label','required' => !$isEdit,'vModel' => 'data.sandi']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Kata Sandi','name' => 'sandi','type' => 'password','placeholder' => '$label','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(!$isEdit),'v-model' => 'data.sandi']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
        <div class="col-md-6">
          <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Konfirmasi Kata Sandi','name' => 'sandi_confirmation','type' => 'password','placeholder' => '$label','required' => !$isEdit,'vModel' => 'data.sandi_confirmation']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Konfirmasi Kata Sandi','name' => 'sandi_confirmation','type' => 'password','placeholder' => '$label','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(!$isEdit),'v-model' => 'data.sandi_confirmation']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0"
    @click="simpanClick">SIMPAN</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script>
    $(function() {
      let userApp = new Vue({
        el: '#<?php echo e($formId); ?>',
        data() {
          return {
            form: null,
            data: {
              role: '',
              status: '',
            },
            photo: null,
          };
        },
        methods: {
          init() {
            this.form = AKForm.validation(`#<?php echo e($formId); ?>`);
            this.photo = new AKCropit('#ciPhoto', {
              width: 300,
              height: 300,
              teksPilih: 'Pilih Foto',
              cropit: {
                imageState: {
                  <?php if(isset($data) && $data->avatar): ?>
                    src: <?php echo json_encode($data->avatar_image, 15, 512) ?>,
                  <?php endif; ?>
                },
                smallImage: "allow",
              },
              responsive: {
                xs: .65,
                sm: .65,
                md: .65,
                lg: .65,
                xl: .65
              }
            })
          },
          async simpanClick() {
            if (!this.form.isValid()) {
              AKToast.error(`Inputan tidak valid`);
              return;
            }
            
            //  Proses form
            let dataKirim = {};
            <?php if($isEdit): ?>
            dataKirim._method = 'PUT';
            dataKirim._id = <?php echo json_encode($data->id, 15, 512) ?>;
            <?php endif; ?>

            for (let i of [
              'role',
              'nama',
              'email',
              'username',
              'status',
              'sandi',
              'sandi_confirmation',
            ]) {
              dataKirim[i] = this.data[i];
            }

            let dataGambar;
            if (this.photo.$selector.find('#akcropit-ifile')[0].files.length) {
              dataGambar = this.photo.export();
              dataKirim.avatar = dataGambar;
            }

            let res;
            AKToast.loading(`Menyimpan Data`, `lp`);
            try {
              res = await axios.post(this.form.$selector.attr('action'), dataKirim);
              if (res.data.success) {
                window.dTables.reload();
                this.form.closeModal();
                AKToast.success(res.data.message);
              }
            } catch (err) {
              res = this.form.handleAxiosError(err);
              AKToast.error(res?.message ?? 'Terjadi kesalahan saat menyimpan');
            } finally {
              AKToast.close('lp');
            }
          },
        },
        mounted() {
          this.init();
          <?php if($isEdit): ?>
          this.data.role = <?php echo json_encode($data->role, 15, 512) ?>;
          this.data.nama = <?php echo json_encode($data->fullname, 15, 512) ?>;
          this.data.email = <?php echo json_encode($data->email, 15, 512) ?>;
          this.data.username = <?php echo json_encode($data->username, 15, 512) ?>;
          this.data.status = <?php echo json_encode($data->status, 15, 512) ?>;
          <?php endif; ?>
        },
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/user/modal-form.blade.php ENDPATH**/ ?>