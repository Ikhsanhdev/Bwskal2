<?php
$title = "Halaman";
?>


<?php echo $__env->make('libs.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
<i class="mdi mdi-file d-none d-md-inline-block mr-3"></i>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-section">
  <div class="card card-table card-table-fit">
    <div class="card-header">
      <div class="title">Daftar <?php echo e($title); ?></div>
      <div class="flex"></div>
      <div class="action">
        <a class="btn btn-primary"
          href="<?php echo e(route('admin.page.create')); ?>">
          <i class="mdi mdi-database-plus mr-2 fz-normal"></i>
          <span>TAMBAH</span>
        </a>
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
          title: '<center>Halaman</center>',
          render: function (row) {
            let t = dayjs(row.tanggal).format('DD MMMM YYYY - HH:mm');
            return `
              <div class="fz-md text-primary">${row.slug}</div>
              <div class="font-weight-bold text-dark">${row.title}</div>
              <div class="fz-md text-muted">Diperbaharui : ${t}</div>
              `;
          }
        },
        { 
          className: 'text-center',
          width: '160px',
          title: 'Aksi',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon"
                href="<?php echo e(url(':slug:')); ?>"
                target="_blank"
                >
                <i class="mdi mdi-database-search"></i>
              </a>
              <a class="btn btn-secondary btn-icon btn-ubah"
                href="<?php echo e(route('admin.page.edit', ['id' => ':id:'])); ?>"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-id="${row.id}"
                data-judul="${row.title}"
                >
                <i class="mdi mdi-trash-can"></i>
              </a>
              `
              .replace(/\:id\:/gm, row.id)
              .replace(/\:slug\:/gm, row.slug)
          },
        }
      ]
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      let judul = this.dataset?.judul || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `<?php echo e(route('admin.page.destroy')); ?>`,
        loadingText: `Menghapus Data`,
        text: `Apakah anda yakin menghapus <strong>"${judul}"</strong>?`,
        data: {
          id: id,
        },
      });
    })
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/page/index.blade.php ENDPATH**/ ?>