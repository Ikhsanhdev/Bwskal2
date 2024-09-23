<div class="modal-body pegawai-modal-body">
  <div class="pegawai-header">
    <div class="text-content">
      <div class="name"><?php echo e($data->name); ?></div>
      <div class="position"><?php echo e($data->position); ?></div>
    </div>
    <img src="<?php echo e($data->foto_image); ?>">
  </div>
  <div class="pegawai-content">
    <?php if($data->content): ?>
    <?php echo $data->content; ?>

    <?php else: ?>
    <div class="text-center">Detail Pegawai belum ada</div>
    <?php endif; ?>
  </div>
</div>
<div class="modal-footer flex-nowrap">
  <button type="button"
    data-dismiss="modal"
    class="btn btn-secondary wide">TUTUP</button>
</div>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/web/pegawai/modal-detail.blade.php ENDPATH**/ ?>