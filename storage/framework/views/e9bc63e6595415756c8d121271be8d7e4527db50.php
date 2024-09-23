<?php
$isEdit = isset($data);
$title = ($isEdit ? 'Ubah' : 'Tambah') . ' Kategori Berita';
$formAction = route('admin.post-category.' . ($isEdit ? 'update' : 'store'));
?>

<?php $__env->startSection('title'); ?>
<i class="mdi mdi-clipboard-text-outline mr-2"></i>
<span class="font-weight-bold"><?php echo e($title); ?></span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['label' => 'Nama Kategori','placeholder' => 'Nama Kategori','name' => 'name','value' => $data->name ?? '','required' => true]]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['label' => 'Nama Kategori','placeholder' => 'Nama Kategori','name' => 'name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->name ?? ''),'required' => true]); ?>
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
    class="btn btn-block btn-secondary mr-3"
    >BATAL</button>
  <button 
    type="submit"
    class="btn btn-block btn-primary m-0"
    >SIMPAN</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
  $(function () {
    AKForm.make({
      datatables: window.dTables,
      indicator: {
        overlay: true,
      },
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/post-category/modal-form.blade.php ENDPATH**/ ?>