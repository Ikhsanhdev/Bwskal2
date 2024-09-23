<?php
$isEdit = true;

switch ($data->status) {
  case 'reject':
    $headerClass = 'modal-danger';
    break;
  case 'approve':
    $headerClass = 'modal-success';
    break;
}

$formId = 'verify-form';
$formAction = route('admin.unduhan.request.verify');
?>

<?php $__env->startSection('title'); ?>
<?php if($data->status == 'pending'): ?>
  <i class="mdi mdi-text-box-search mr-2"></i>
  <span class="font-weight-bold">Verifikasi Permohonan Akses</span>
<?php else: ?>
<div class="d-flex align-items-center lh-1">
  <i class="mdi mdi-text-box-search fz-2rem mr-3"></i>
  <div class="lh-1-25">
    <div class="font-weight-bold">Detail Permohonan Akses</div>
    <div class="fz-0-8rem"><?php echo e($data->status_text); ?></div>
  </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <div class="fw-700 fz-1-15rem mb-2">Unduhan tujuan</div>
  <div class="bg-light lh-1-15 rounded-sm d-flex flex justify-content-center align-items-center flex-column py-3">
    <i class="fi <?php echo flaticon_from_mime($unduhan->mime); ?> fz-4rem"></i>
    <div class="fw-800 fz-1-25rem mb-1"><?php echo e($unduhan->title); ?></div>
    <div class="fz-0-85rem text-muted">Diunduh <?php echo e($unduhan->hit); ?> kali</div>
  </div>

  <div class="fw-700 fz-1-15rem mt-2">Detail Permohonan</div>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-text','data' => ['label' => 'Diajukan pada','value' => $data->created_at->isoFormat('DD MMMM YYYY')]]); ?>
<?php $component->withName('ak-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Diajukan pada','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->created_at->isoFormat('DD MMMM YYYY'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-text','data' => ['label' => 'Nama Pemohon','value' => $data->name]]); ?>
<?php $component->withName('ak-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Nama Pemohon','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->name)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-text','data' => ['label' => 'Email Pemohon','value' => $data->email]]); ?>
<?php $component->withName('ak-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Email Pemohon','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->email)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-text','data' => ['label' => 'Tujuan/ Keperluan Permintaan Dokumen','value' => $data->message]]); ?>
<?php $component->withName('ak-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Tujuan/ Keperluan Permintaan Dokumen','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->message)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <hr class="mb-2">

  <?php if($data->status == 'pending'): ?>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-select','data' => ['label' => 'Status Permohonan','name' => 'status','required' => true,'vModel' => 'data.status','placeholder' => 'Pilih Status Permohonan','list' => ['approve' => 'Diterima', 'reject' => 'Ditolak']]]); ?>
<?php $component->withName('ak-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Status Permohonan','name' => 'status','required' => true,'v-model' => 'data.status','placeholder' => 'Pilih Status Permohonan','list' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['approve' => 'Diterima', 'reject' => 'Ditolak'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <template v-if="data.status == 'reject'">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'message','label' => 'Alasan Penolakan','placeholder' => '$label','vModel' => 'data.message','type' => 'textarea']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'message','label' => 'Alasan Penolakan','placeholder' => '$label','v-model' => 'data.message','type' => 'textarea']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
  </template>
  <?php else: ?>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-text','data' => ['label' => 'Status Permohonan','value' => $data->status_text]]); ?>
<?php $component->withName('ak-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Status Permohonan','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->status_text)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
  <?php if($data->status == 'reject'): ?>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-text','data' => ['label' => 'Alasan Penolakan','value' => $data->admin_message ?? '-']]); ?>
<?php $component->withName('ak-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Alasan Penolakan','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->admin_message ?? '-')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
  <?php endif; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
<?php if($data->status == 'pending'): ?>
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0" type="button"
    @click="submit">SIMPAN</button>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php if($data->status == 'pending'): ?>
<script>
  $(function () {
    let verifyApp = new Vue({
      el: `#<?php echo e($formId); ?>`,
      data() {
        return {
          form: null,
          data: {
            status: '',
          },
        };
      },
      methods: {
        init() {
          this.form = AKForm.validation(`#<?php echo e($formId); ?>`);
        },
        async submit() {
          if (!this.form.isValid()) {
            AKToast.error(`Inputan tidak valid`);
            return;
          }

          let payload = {
            id: <?php echo json_encode($data->id, 15, 512) ?>,
            status: this.data.status,
            message: this.data?.message ?? null,
          };

          AKToast.loading(`Menyimpan Data`, `lp`);
          try {
            res = await axios.post(this.form.$selector.attr('action'), payload);
            if (res.data.success) {
              this.form.closeModal();
              window.dTables.reload();
              AKToast.success(res.data.message);
            }
          } catch (err) {
            res = this.form.handleAxiosError(err);
            AKToast.error(res?.message ?? 'Terjadi kesalahan saat menyimpan');
          } finally {
            AKToast.close('lp');
          }
        }
      },
      mounted() {
        this.init();
      },
    });
  })
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/unduhan/request/modal-detail.blade.php ENDPATH**/ ?>