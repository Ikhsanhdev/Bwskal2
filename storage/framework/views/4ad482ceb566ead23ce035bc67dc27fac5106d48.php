<?php
$title = "Direktori/Unduhan";
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
<i class="mdi mdi-file-download d-none d-md-inline-block mr-3"></i>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-section">
  
  <div class="card card-table card-table-fit">
    <div class="card-header">
      <div class="title">Daftar Berkas</div>
      <div class="flex"></div>
      <div class="action btn-list-horizontal">
        <a class="btn btn-secondary" href="<?php echo e(route('admin.unduhan.request.index')); ?>">
          <i class="mdi mdi-clipboard-check mr-2 fz-normal"></i>
          <span>VERIFIKASI</span>
          <?php if(isset($_menuBadge['unduhan_request']) && $_menuBadge['unduhan_request'] > 0): ?>
          <span class="ml-2 mt-1 badge badge-light fz-0-75rem"><?php echo e($_menuBadge['unduhan_request']); ?></span>
          <?php endif; ?>
        </a>
        <a class="btn btn-secondary" href="<?php echo e(route('admin.unduhan.kategori.index')); ?>">
          <i class="mdi mdi-tag mr-2 fz-normal"></i>
          <span>KATEGORI</span>
        </a>
        <a class="btn btn-primary" href="#" id="btnTambah">
          <i class="mdi mdi-database-plus mr-2 fz-normal"></i>
          <span>TAMBAH</span>
        </a>
      </div>
    </div>
    <table class="table table-bordered table-fit table-hover table-striped w-100" id="tablenya"></table>
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
          title: '<center>Berkas</center>',
          render: function (row) {
            let t = dayjs(row.updated_at).format(`DD MMMM YYYY - HH:mm`);

            return `
              <div class="fz-md text-primary">${row.category_name}</div>
              <div class="font-weight-bold text-dark">${row.title}</div>
              <div class="fz-md text-muted">${t}</div>
              `;
          }
        },
        { 
          className: 'text-center',
          width: '110px',
          title: 'Aksi',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-ubah"
                data-id="${row.id}"
                data-judul="${row.title}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-id="${row.id}"
                data-judul="${row.title}"
                >
                <i class="mdi mdi-trash-can"></i>
              </a>
              `;
          },
        }
      ]
    })
    .on('click', '.btn-ubah', function (e) {
      e.preventDefault();
      AKModal.open({
        url: `<?php echo e(route('admin.unduhan.edit')); ?>`,
        data: {
          id: $(this).data('id'),
        },
        size: 'lg',
      });
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      let judul = this.dataset?.judul || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `<?php echo e(route('admin.unduhan.destroy')); ?>`,
        loadingText: `Menghapus Data`,
        text: `Apakah anda yakin menghapus <strong>"${judul}"</strong>?`,
        data: {
          id: id,
        },
      });
    })
    $('#btnTambah').on('click', () => AKModal.open(
      {
        url: `<?php echo e(route('admin.unduhan.create')); ?>`,
        size: 'lg',
      }
    ));
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/unduhan/index.blade.php ENDPATH**/ ?>