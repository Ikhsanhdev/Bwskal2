<?php
  $title = 'Feed Media Sosial';
?>


<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.day', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('adminHeader'); ?>
  <i class="mdi mdi-timeline-text-outline d-none d-md-inline-block mr-3"></i>
  <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  
  <div class="admin-section">
    <form class="card"
      id="formnya"
      method="POST"
      action="<?php echo e(route('admin.medsos-feed.update')); ?>">
      <?php echo method_field('PUT'); ?>
      <div class="card-header">
        <div class="font-weight-bold fz-lg text-dark">Feed Media Sosial</div>
      </div>
      <div class="card-body">
        <?php if(config('medsos-feed.instagram.app_id') && config('medsos-feed.instagram.app_secret')): ?>
        <h4 class="text-dark fw-800">Instagram</h4>
        <div class="fz-0-85rem">Feed Instagram akan otomatis diperbaharui setiap 30 menit, atau gunakan tombol <strong>Refresh Feed</strong> (akan muncul jika access token tersedia).</div>
        <div class="form-group">
          <label for="">Instagram Access Token</label>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Access Token" readonly value="<?php echo e($data->ig_token ?? ''); ?>">
            <div class="input-group-append">
              <a class="btn btn-warning fz-0-9rem" href="<?php echo e($igLoginUrl); ?>">Get Access Token</a>
            </div>
          </div>
          <?php if($data->ig_token && $data->ig_token_expire): ?>
          <div class="mt-1 fz-0-85rem">Token ini akan expired pada <span class="fw-700 text-danger"><?php echo e(\Carbon\Carbon::createFromTimestamp($data->ig_token_expire)->isoFormat('DD MMMM YYYY HH:mm:ss')); ?></span></div>
          <?php endif; ?>
        </div>
        <?php if($data->ig_token): ?>
        <button type="button" class="btn btn-warning fz-0-9rem" id="btnRefreshIG">
          <i class="mdi mdi-refresh mr-2"></i>
          <span>Refresh Feed</span>
        </button>
        <?php endif; ?>
        <hr>
        <?php endif; ?>
        <h4 class="text-dark fw-800">Media Sosial Lainnya</h4>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'facebook','label' => 'Facebook URL','placeholder' => '$label','value' => $data->facebook ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'facebook','label' => 'Facebook URL','placeholder' => '$label','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->facebook ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.ak-input','data' => ['name' => 'twitter','label' => 'Twitter URL','placeholder' => '$label','value' => $data->twitter ?? '']]); ?>
<?php $component->withName('ak-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['name' => 'twitter','label' => 'Twitter URL','placeholder' => '$label','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data->twitter ?? '')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
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
      AKForm.make({
        indicator: {
          overlay: true
        },
      });

      $('#btnRefreshIG').on('click', function () {
        let l = AKToast.loading(`Refresh Instagram Feed`);
        axios.post(`<?php echo e(route('admin.medsos-feed.refresh-ig')); ?>`)
          .then(res => {
            AKToast.success(res.data.message);
          })
          .catch(err => {
            AKToast.error(err?.response?.data?.message ?? err.message)
          })
          .finally(() => {
            l.close();
          });
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/admin/medsos-feed/index.blade.php ENDPATH**/ ?>