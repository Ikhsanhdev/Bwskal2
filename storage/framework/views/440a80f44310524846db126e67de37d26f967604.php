<?php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Pengumuman';
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.cropit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.flatpickr', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
<i class="mdi mdi-bullhorn d-none d-md-inline-block mr-3"></i>
Pengumuman
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-content-title">
  <a href="<?php echo e(route('admin.announcement.index')); ?>"
    class="btn btn-icon text-primary px-2">
    <i class="mdi mdi-arrow-left-thick fz-lg"></i>
  </a>
  <div class="font-weight-bold fz-normal ml-2"><?php echo e($title); ?></div>
</div>


<div class="admin-section">
  <form class="card"
    id="formnya"
    method="POST"
    action="<?php echo e(route('admin.announcement.' . ($isEdit ? 'update' : 'store'))); ?>">
    <?php if($isEdit): ?>
    <?php echo method_field('PUT'); ?>
    <input type="hidden"
      name="_id"
      value="<?php echo e($data->id); ?>" />
    <?php endif; ?>
    <div class="card-body">
      
      <div class="form-group">
        <label class="control-label mb-0"
          for="cover">Sampul <span class="fz-md font-weight-normal">(Opsional, Minimal berukuran 900px x 350px)</span></label>
        <div id="ciSampul"
          class="ak-cropit"
          data-name="cover"></div>
      </div>
      
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Judul Pengumuman','placeholder' => 'Judul Pengumuman','name' => 'title','value' => $data->title ?? '','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Judul Pengumuman','placeholder' => 'Judul Pengumuman','name' => 'title','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->title ?? ''),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
      
      <div class="form-group">
        <label for="">Tanggal Aktif</label>
        <input type="text"
          class="form-control"
          name="tgl_aktif"
          placeholder="Tanggal pengumuman aktif"
          autocomplete="off"
          value="<?php echo e(isset($waktu) ? $waktu : ''); ?>"
          >
      </div>

      <div class="form-group">
        <label class="control-label"
          for="content">Isi</label>
        <textarea name="content"
          id="content"
          class="form-control"><?php echo e($data->content ?? ''); ?></textarea>
      </div>
    </div>
    <div class="card-footer text-right">
      <button class="btn btn-primary">SIMPAN</button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
<script src="<?php echo e(url('libs/ckeditor/ckeditor.js')); ?>"></script>
<script>
  $(async function () {
    let topViewport = document.querySelector('.admin-header').offsetHeight + 40;
    let editorOptions = {
      ui: {
        viewportOffset: {
          top: topViewport,
        }
      },
    };
    let contentEditor = await AKCKEditorMake(document.querySelector('#content'), editorOptions);

    let tInfo;
    var taIsi = $('#isinya');
    $('[name="tgl_aktif"]').flatpickr({
      mode: 'range',
      altInput: true,
      altFormat: 'j F Y',
      dateFormat: 'd:m:Y',
    });
    window.ciSampul = new AKCropit('#ciSampul', {
      width: 900,
      height: 350,
      teksPilih: 'Pilih',
      responsive: {
        xs: .3,
        sm: .5,
        md: .75,
        lg: .75,
        xl: .75
      },
      <?php if($isEdit && $data->cover): ?>
      cropit: {
        imageState: {
          src: '<?php echo e(url("uploads/announcement/" . $data->cover)); ?>'
        },
      },
      <?php endif; ?>
    }); 
    window.fForm = AKForm.make({
      dataBuilder: function (data) {
        data.forEach(d => {
          if (d.name == 'tgl_aktif' && d.value.indexOf('-') == -1) {
            d.value = d.value + ' - ' + d.value;
          } else if (d.type == "file" && d.name == "cover" && d.value != "") {
            d.value = ciSampul.export();
          }
        });
        return data;
      }
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/announcement/form.blade.php ENDPATH**/ ?>