<?php
$title = "Kategori Unduhan";
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
<i class="mdi mdi-file-downlad d-none d-md-inline-block mr-3"></i>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-content-title">
  <a href="<?php echo e(route('admin.unduhan.index')); ?>"
    class="btn btn-icon text-primary px-2">
    <i class="mdi mdi-arrow-left-thick fz-lg"></i>
  </a>
  <div class="font-weight-bold fz-normal ml-2"><?php echo e($title); ?></div>
</div>


<div class="admin-section">
  
  <div class="card card-table card-table-fit">
    <div class="card-header">
      <div class="title">Daftar <?php echo e($title); ?></div>
      <div class="flex"></div>
      <div class="action btn-list-horizontal">
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
  $(document).ready(function () {
    <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>
    window.dTables = AKTable.make({
      columns: [
        { 
          data: '@nomor', 
          width: '50px',
          title: 'No.',
          className: 'text-center',
        },
        { 
          title: '<center>Kategori</center>',
          render: function (row) {
            return `<div class="font-weight-bold">${row.name}</div>
            <div class="fz-md text-muted">${row.slug}</div>
            `;
          }
        },
        { 
          className: 'text-center',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-ubah"
                data-judul="${row.name}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-judul="${row.name}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-trash-can-outline"></i>
              </a>
                `;
          },
          width: '150px',
          title: 'Aksi'
        }
      ]
    })
    .on('click', '.btn-ubah', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      if (! id) return;
      AKModal.open({
        url: `<?php echo e(route('admin.unduhan.kategori.edit')); ?>`,
        data: {
          id,
        },
      });
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      let judul = this.dataset?.judul || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `<?php echo e(route('admin.unduhan.kategori.destroy')); ?>`,
        loadingText: `Menghapus Kategori Unduhan`,
        text: `Apakah anda yakin menghapus <strong>"${judul}"</strong>?`,
        data: {
          id: id,
        },
      });
    });
    
    $('#btnTambah').on('click', function (e) {
      e.preventDefault();
      AKModal.open(`<?php echo e(route('admin.unduhan.kategori.create')); ?>`);
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/unduhan/kategori/index.blade.php ENDPATH**/ ?>