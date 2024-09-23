<?php
  $title = 'Lupa Sandi';
  $bodyClass = 'bg-primary-3';
?>

<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
  <div class="bg-dot">
    <div class="bg-ornament-1"></div>
    <div class="row h-100v justify-content-center align-items-center m-0 overflow-hidden">
      <div class="col-12 col-md-8 col-lg-4">
        <div class="admin-content mb-3">
          <div class="app-branding on-dark justify-content-center flex-column lh-1">
            <img src="<?php echo e(url('assets/images/logo-baru.svg')); ?>"
              alt="Logo"
              class="img-fluid mb-3"
              style="image-rendering: optimizeQuality">
          </div>
          <div class="card card-login"
            style="margin-top: 1.75rem;">
            <div class="card-body pt-3">
              <form action="<?php echo e(route('lupa-sandi.store')); ?>"
                method="POST"
                id="formnya">
                <?php echo csrf_field(); ?>
                <h5 class="font-weight-600 text-dark2">Form Lupa Sandi</h5>
                <div class="fz-0-9rem text-muted mb-3">Silakan masukkan email yang terdaftar untuk dikirim instruksi reset kata sandi.</div>
                <div class="form-group">
                  <label>Alamat Email</label>
                  <input type="text"
                    class="form-control fz-0-8rem"
                    placeholder="Alamat Email"
                    name="email"
                    required
                    autofocus>
                </div>
                <button class="btn btn-block btn-primary is-btn mt-2">
                  <div class="fz-normal">KIRIM INSTRUKSI</div>
                </button>
                <a href="<?php echo e(route('login')); ?>"
                  class="btn btn-secondary btn-block is-btn mt-2">
                  <div class="fz-normal">KEMBALI KE LOGIN</div>
                </a>
              </form>
            </div>
          </div>
        </div>
        <?php echo $__env->make('layouts.admin.footer-center', [
          'footerClass' => 'm-0 text-light',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('jsAfterMain'); ?>
  <script>
    $(document).ready(function() {
      window.fForm = AKForm.make({
        indicator: {
          overlay: true,
          message: `Sedang proses`,
        }
      });
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/auth/lupa-sandi.blade.php ENDPATH**/ ?>