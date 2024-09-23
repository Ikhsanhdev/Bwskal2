<?php
  $title = 'Pengaturan Web';
?>


<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.vue-draggable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-cog d-none d-md-inline-block mr-3"></i>
  <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  
  <div class="admin-content-title">
    <a href="<?php echo e(route('admin.pengaturan-situs.index')); ?>"
      class="btn btn-icon text-primary px-2">
      <i class="mdi mdi-arrow-left-thick fz-lg"></i>
    </a>
    <div class="font-weight-bold fz-normal ml-2">Media Sosial</div>
  </div>

  
  <div class="admin-section">
    <div id="listApp"
      data-class="mb-5"
      data-judul="Media Sosial"
      data-url="<?php echo e(route('admin.pengaturan-situs.update', ['page' => 'media-sosial'])); ?>">
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
  <script>
    $(function() {
      <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>

      let medsosApp = initListApp('#listApp', {
        initData: <?php echo json_encode($data ?? [], 15, 512) ?>,
        skemaData: [
          {
            name: "Tipe",
            key: "type",
            type: "select",
            value: [{
                text: 'Website',
                value: 'web',
              },
              {
                text: 'Facebook',
                value: 'facebook',
              },
              {
                text: 'Twitter',
                value: 'twitter',
              },
              {
                text: 'Linkedin',
                value: 'linkedin',
              },
              {
                text: 'Instagram',
                value: 'instagram',
              },
              {
                text: 'Youtube',
                value: 'youtube',
              },
            ],
            required: true,
          },
          {
            name: "Nama",
            key: "name",
            type: "text",
            required: true,
          },
          {
            name: "Link",
            key: "link",
            type: "text",
          },
        ],
        slot: {
          item: `
        <i class="mdi fz-2rem mr-2 medsos-link-colored"
          :class="[{
            'mdi-web' : s.item.type == 'web',
            'mdi-facebook' : s.item.type == 'facebook',
            'mdi-twitter' : s.item.type == 'twitter',
            'mdi-linkedin' : s.item.type == 'linkedin',
            'mdi-instagram' : s.item.type == 'instagram',
            'mdi-youtube' : s.item.type == 'youtube',
          }, s.item.type]"></i>
        <div>
          <div class="teks mb-0">{{ s.item.name }}</div>
          <div class="subteks mt-0">{{ s.item.link }}</div>
        </div>
        `,
        }
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/pengaturan-situs/media-sosial.blade.php ENDPATH**/ ?>