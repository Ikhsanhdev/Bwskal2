<?php
  $isEdit = isset($data);
  $title = ($isEdit ? 'Ubah' : 'Tambah') . ' Agenda';
  
  $formId = 'agendaForm';
  $formAction = route('admin.agenda.' . ($isEdit ? 'update' : 'store'));
?>

<?php $__env->startSection('title'); ?>
  <i class="mdi mdi-calendar-clock mr-2"></i>
  <span class="font-weight-bold"><?php echo e($title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Judul','placeholder' => '$label','name' => 'title','value' => $data->title ?? '','vModel' => 'data.title','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Judul','placeholder' => '$label','name' => 'title','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->title ?? ''),'v-model' => 'data.title','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Lokasi','placeholder' => '$label','name' => 'location','value' => $data->location ?? '','vModel' => 'data.location']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Lokasi','placeholder' => '$label','name' => 'location','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->location ?? ''),'v-model' => 'data.location']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
  <div class="form-group" id="w-tanggal">
    <label for="">Tanggal</label>
    <date-picker v-model="data.tanggal"
      type="date"
      format="DD MMMM YYYY"
      value-type="DD-MM-YYYY"
      class="w-100"
      :input-attr="{name:'tanggal',required:true,'data-errors-container':'#w-tanggal'}"
      placeholder="Pilih tanggal agenda"
      range
      @input="datePickerChange('tanggal')"
      
      ></date-picker>
  </div>
  <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['type' => 'textarea','label' => 'Keterangan','placeholder' => '$label','name' => 'description','value' => $data->description ?? '','optional' => true,'vModel' => 'data.description']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['type' => 'textarea','label' => 'Keterangan','placeholder' => '$label','name' => 'description','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->description ?? ''),'optional' => true,'v-model' => 'data.description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

  <ak-file name="lampiran"
    ref="lampiran"
    label="Lampiran"
    subtitle="Bertipe pdf, ppt, pptx, doc, docx, xls, xlsx, zip atau gambar (Max 50MB)."
    optional
    v-model="data.lampiran" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
  <button type="button"
    data-dismiss="modal"
    class="btn btn-block btn-secondary mr-3">BATAL</button>
  <button class="btn btn-block btn-primary m-0"
    @click="submit">SIMPAN</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script>
    $(function() {
      let mApp = new Vue({
        el: `#<?php echo e($formId); ?>`,
        data() {
          return {
            form: null,
            data: {},
          };
        },
        methods: {
          init() {
            this.form = AKForm.validation(`#<?php echo e($formId); ?>`);
          },
          datePickerChange(name) {
            this.$nextTick(() => {
              $(`[name="${name}"]`)?.parsley()?.validate();
            });
          },
          async submit() {
            if (!this.form.isValid()) {
              AKToast.error(`Inputan tidak valid`);
              return;
            }

            let payload = new FormData();
            <?php if($isEdit): ?>
              payload.append('_method', 'PUT');
              payload.append('_id', <?php echo json_encode($data->id, 15, 512) ?>);
            <?php endif; ?>

            payload.append('title', this.data.title);
            payload.append('location', this.data.location);
            payload.append('tanggal', this.data.tanggal);
            payload.append('description', this.data.description);

            if (this.data.lampiran?.file) {
              payload.append('lampiran', this.data.lampiran.file);
            } else if (this.data.lampiran?.deleted) {
              payload.append('lampiran_deleted', 1);
            }

            let res;
            AKToast.loading(`Menyimpan Data`, `lp`);
            try {
              res = await axios.post(this.form.$selector.attr('action'), payload);
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
          this.$set(this, 'data', {
            title: <?php echo json_encode($data->title, 15, 512) ?>,
            location: <?php echo json_encode($data->location, 15, 512) ?>,
            description: <?php echo json_encode($data->description, 15, 512) ?>,
            tanggal: <?php echo json_encode($data->tanggal, 15, 512) ?>,
          });
          <?php if($data->attachment): ?>
          this.$refs.lampiran.setOldFile(<?php echo json_encode($data->attachment_url, 15, 512) ?>);
          <?php endif; ?>
          <?php endif; ?>
        },
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/agenda/modal-form.blade.php ENDPATH**/ ?>