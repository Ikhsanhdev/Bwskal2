<?php
$title = "Verifikasi permohonan akses";
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.datatables', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
<i class="mdi mdi-file-download d-none d-md-inline-block mr-3"></i>
Direktori/Unduhan
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
      <div class="title">Daftar Permohonan Akses</div>
      <div class="flex"></div>
      <div class="action btn-list-horizontal">
      </div>
    </div>
    <table class="table table-bordered table-fit table-hover table-striped w-100" id="tablenya"></table>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('cssAfterMain'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
<script>
  $(function () {
    <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>
    window.statusMap = <?php echo json_encode(\App\Models\UnduhanAkses::getStatusList(), 15, 512) ?>;
    window.statusBadgeMap = <?php echo json_encode(status_badge_list(), 15, 512) ?>;

    window.dTables = AKTable.make({
      columns: [
        { 
          data: '@nomor',
        },
        { 
          title: '<center>Permohonan</center>',
          render: function (row) {
            let t = dayjs(row.updated_at).format(`DD MMMM YYYY - HH:mm`);

            return `
              <div class="fz-md text-primary">${row.email}</div>
              <div class="font-weight-bold text-dark">${row.name}</div>
              <div class="fz-md text-secondary">Permohonan akses <strong>${row.unduhan_title}</strong></div>
              <div class="fz-md text-muted">Pada ${t}</div>
              `;
          }
        },
        {
          title: '<center>Status</center>',
          className: 'text-center',
          width: '130px',
          render: row => {
            let s = statusBadgeMap[row.status];
            return `<div class="badge ${s.class} fz-md fw-700 px-3 py-2">${s.text}</div>`;
          }
        },
        { 
          className: 'text-center',
          width: '110px',
          title: 'Aksi',
          render: function(data, type, row) {
            return `
              <a class="btn btn-secondary btn-icon btn-verifikasi"
                data-id="${row.id}"
                >
                <i class="mdi mdi-text-box-search mr-2"></i>
                <span class="fz-0-75rem">${row.status == 'pending' ? 'VERIFIKASI' : 'DETAIL' }</span>
              </a>
              `;
          },
        }
      ]
    })
    .on('click', '.btn-verifikasi', function (e) {
      e.preventDefault();
      AKModal.open({
        url: `<?php echo e(route('admin.unduhan.request.detail')); ?>`,
        data: {
          id: $(this).data('id'),
        },
      });
    })
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/unduhan/request/index.blade.php ENDPATH**/ ?>