<?php
$title = "Kontak Form";
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
<i class="mdi mdi-card-account-phone d-none d-md-inline-block mr-3"></i>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-section">
  <div class="card card-table card-table-fit">
    <div class="card-header">
      <div class="title">Data <?php echo e($title); ?></div>
      <div class="flex"></div>
      <div class="action">
      </div>
    </div>
    <table id="tablenya"
      class="table table-bordered table-fit table-hover table-striped w-100"></table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
<script>
  $(function () {
    <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>
    window.dTables = AKTable.make({
      columns: [
        { 
          data: '@nomor',
        },
        { 
          title: '<center>Data</center>',
          render: function (row) {
            return `
              <div class="fz-md text-primary fw-700">${row.topic}</div>
              <div class="font-weight-bold text-dark">${row.name}</div>
              <div class="fz-md text-muted fw-600">${row.email}</div>
              `;
          }
        },
        { 
          title: '<center>Tanggal</center>',
          width: '200px',
          className: 'text-center',
          render: function (row) {
            return dayjs(row.created_at).format('DD MMMM YYYY - HH:mm');
          }
        },
        { 
          className: 'text-center',
          width: '110px',
          title: 'Aksi',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-detail"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-search"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-id="${row.id}"
                >
                <i class="mdi mdi-trash-can"></i>
              </a>
              `;
          },
        }
      ]
    })
    .on('click', '.btn-detail', function (e) {
      e.preventDefault();
      AKModal.open({
        url: `<?php echo e(route('admin.kontak-form.edit')); ?>`,
        data: {
          id: $(this).data('id'),
        },
      });
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `<?php echo e(route('admin.kontak-form.destroy')); ?>`,
        loadingText: `Menghapus Data`,
        text: `Apakah anda yakin menghapus data ini?`,
        data: {
          id: id,
        },
      });
    })
  });
</script>
<?php $__env->stopSection(); ?> 

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/kontak-form/index.blade.php ENDPATH**/ ?>