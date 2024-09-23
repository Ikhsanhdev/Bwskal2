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
    <div class="font-weight-bold fz-normal ml-2">Informasi</div>
  </div>

  
  <div class="admin-section">
    <form class="card"
      id="formnya"
      method="POST"
      action="<?php echo e(route('admin.pengaturan-situs.update', ['page' => 'informasi'])); ?>">
      <?php echo method_field('PUT'); ?>
      <div class="card-body">
        <div class="font-weight-bold fz-lg text-dark">Informasi Web</div>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'profil','label' => 'Profil Singkat','placeholder' => '$label','type' => 'textarea','value' => $data->profil ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'profil','label' => 'Profil Singkat','placeholder' => '$label','type' => 'textarea','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->profil ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'telepon','label' => 'Nomor Telepon','value' => $data->telepon ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'telepon','label' => 'Nomor Telepon','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->telepon ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <div class="font-weight-bold fz-lg text-dark d-flex align-items-center">
          <div>Informasi Kontak</div>
          <div class="flex"></div>
          <div>
            <button class="btn btn-secondary"
              type="button"
              id="btnTambahInfo">TAMBAH</button>
          </div>
        </div>
        <div id="infoApp"
          data-class="my-3 p-3 bg-light rounded"
          data-judul="Informasi Kontak"></div>
      </div>
      <div class="card-footer text-right">
        <button class="btn btn-primary text-uppercase fz-1rem"
          type="submit">SIMPAN</button>
      </div>
    </form>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
  <script>
    $(function() {
      <?php if(session('error')): ?> AKToast.error(`<?php echo session('error'); ?>`); <?php endif; ?>

      let infoApp = initListApp('#infoApp', {
        inCard: true,
        typeMap: {
          "email": "Email",
          "link": "Link",
          "phone": "Telepon",
          "text": "Teks",
        },
        initData: <?php echo json_encode(json_decode($data->kontak_list ?? '[]'), 15, 512) ?>,
        skemaData: [{
            name: `Nama`,
            key: 'name',
            type: 'text',
            required: true,
          },
          {
            name: "Tipe",
            key: "type",
            type: "select",
            value: [
              {
                text: 'Email',
                value: 'email',
              },
              {
                text: 'Link',
                value: 'link',
              },
              {
                text: 'Telepon',
                value: 'phone',
              },
              {
                text: 'Teks',
                value: 'text',
              },
            ],
            required: true,
          },
          {
            name: `Kontak`,
            key: 'value',
            type: 'text',
            required: true,
          }
        ],
        slot: {
          item: `
          <div>
            <div class="fz-0-75rem text-primary fw-700">{{ opt.typeMap[s.item.type] }}</div>
            <div class="teks">{{ s.item.name }}</div>
            <div class="subteks mt-0">{{ s.item.value }}</div>
          </div>
          `,
        }
      });

      $('#btnTambahInfo').on('click', function() {
        infoApp.$refs.app.tambahOnClick();
      });

      setTimeout(() => {
        AKForm.make({
          indicator: {
            overlay: true
          },
          dataBuilder: (data) => {
            data.push({
              name: 'kontak_list',
              type: 'text',
              value: JSON.stringify(infoApp.getData() ?? []),
            });
            return data;
          },
        });
      }, 700);
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/pengaturan-situs/informasi.blade.php ENDPATH**/ ?>