<?php
$title = "Slide";
?>

<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.cropit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
<i class="mdi mdi-camera-burst d-none d-md-inline-block mr-3"></i>
<?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
  $(function () {
    window.tipeMap = <?php echo json_encode(\App\Models\Slide::getTypeList(), 15, 512) ?>;
    window.dTables = AKTable.make({
      columns: [
        { 
          data: '@nomor', 
          width: '50px',
          title: 'No.',
          className: 'text-center',
        },
        { 
          title: '<center>Slide</center>',
          render: function (row) {
            let t = dayjs(row.tanggal).format('DD MMMM YYYY - HH:mm');
            return `
            <div class="fz-md text-primary d-flex align-items-center">${row.featured_at ? '<span class="badge badge-warning font-weight-bold text-white fz-0-75rem mr-2">Featured</span>' : ''}${tipeMap[row.type]}</div>
            <div class="font-weight-bold">${row.title}</div>
            <div class="fz-md text-muted">Diperbaharui : ${t}</div>
            `;
          }
        },
        { 
          className: 'text-center',
          render: function(data, type, row) {
            let t = '';
            if (!row.featured_at) {
              t = `<a class="btn btn-secondary btn-icon btn-ubah"
                data-judul="${row.title}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>`;
            }
            return `
              ${t}
              <a class="btn btn-danger btn-icon btn-hapus"
                data-judul="${row.title}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-trash-can-outline"></i>
              </a>
                `
              .replace(/\:id\:/gm, row.id);
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
        url: `<?php echo e(route('admin.slide.edit')); ?>`,
        data: {
          id,
        },
      });
    })
    .on('click', '.btn-hapus', function (e) {
      e.preventDefault();
      let id = this.dataset?.id || null;
      if (! id) return;
      AKHelper.DeleteConfirm({
        datatables: window.dTables,
        url: `<?php echo e(route('admin.slide.destroy')); ?>`,
        loadingText: `Menghapus Slide`,
        text: `Apakah anda yakin menghapus slide "${this.dataset.judul}" ?`,
        data: {
          id: id,
        },
      });
    });
    $('#btnTambah').on('click', function (e) {
      e.preventDefault();
      AKModal.open(`<?php echo e(route('admin.slide.create')); ?>`);
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/slide/index.blade.php ENDPATH**/ ?>