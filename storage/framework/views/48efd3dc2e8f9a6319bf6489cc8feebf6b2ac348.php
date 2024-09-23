<?php
$title = 'Pengguna';
?>

<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.cropit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-account-group d-none d-md-inline-block mr-3"></i>
  <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="admin-section">
    <div class="card card-table card-table-fit">
      <div class="card-header">
        <div class="title">Daftar <?php echo e($title); ?></div>
        <div class="flex"></div>
        <div class="action">
          <div class="btn btn-primary"
            id="btnTambah">
            <i class="mdi mdi-database-plus fz-normal mr-2"></i>
            <span>TAMBAH</span>
          </div>
        </div>
      </div>
      <table id="tablenya"
        class="table-bordered table-fit table-hover table-striped w-100 table"></table>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
  <script>
    $(function() {
      window.roleMap = <?php echo json_encode(\App\Models\User::getRoleList(), 15, 512) ?>;
      window.statusMap = <?php echo json_encode(\App\Models\User::getStatusList(), 15, 512) ?>;
      window.statusBadgeMap = <?php echo json_encode(status_badge_list(), 15, 512) ?>;

      window.dTables = AKTable.make({
          columns: [{
              data: '@nomor',
            },
            {
              title: '<center>Pengguna</center>',
              render: function(row) {
                return `<div class="fz-md fw-700 text-primary">${roleMap[row.role] ?? 'Tidak diketahui'}</div>
            <div class="font-weight-bold">${row.fullname}</div>
            <div class="fz-md text-muted">${row.email}</div>
            `;
              }
            },
            {
              title: '<center>Status</center>',
              className: 'text-center',
              width: '160px',
              render: row => {
                return `<div class="badge ${statusBadgeMap[row.status].class} fz-md fw-700 px-3 py-2">${statusMap[row.status]}</div>`;
              }
            },
            {
              className: 'text-center',
              render: function(data, type, row) {
                return `
              <a class="btn btn-secondary btn-icon btn-ubah"
                data-judul="${row.fullname}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-database-edit"></i>
              </a>
              <a class="btn btn-danger btn-icon btn-hapus"
                data-judul="${row.fullname}"
                data-id="${row.id}"
                >
                <i class="mdi mdi-trash-can-outline"></i>
              </a>
                `.replace(/\:\:id\:\:/gm, row.id);
              },
              width: '160px',
              title: 'Aksi'
            }
          ]
        })
        .on('click', '.btn-detail', function(e) {
          e.preventDefault();
          AKModal.open({
            url: `<?php echo e(route('admin.user.detail')); ?>`,
            data: {
              id: $(this).data('id'),
            },
          });
        })
        .on('click', '.btn-ubah', function(e) {
          e.preventDefault();
          AKModal.open({
            url: `<?php echo e(route('admin.user.edit')); ?>`,
            data: {
              id: $(this).data('id'),
            },
            size: 'lg',
          });
        })
        .on('click', '.btn-hapus', function(e) {
          e.preventDefault();
          let id = this.dataset?.id || null;
          let judul = this.dataset?.judul || null;
          if (!id) return;
          AKHelper.DeleteConfirm({
            datatables: window.dTables,
            url: `<?php echo e(route('admin.user.destroy')); ?>`,
            loadingText: `Menghapus Data`,
            text: `Apakah anda yakin menghapus <strong>"${judul}"</strong>?`,
            data: {
              id: id,
            },
          });
        })
      $('#btnTambah').on('click', () => AKModal.open({
        url: `<?php echo e(route('admin.user.create')); ?>`,
        size: 'lg',
      }));
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/user/index.blade.php ENDPATH**/ ?>