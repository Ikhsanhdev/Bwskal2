<?php
  $title = 'Login';
  $bodyClass = 'bg-primary-3';
?>

<?php echo $__env->make('libs.akform', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('libs.izitoast', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
  <div class="bg-dot">
    <div class="bg-ornament-1"></div>
    <div class="row h-100v justify-content-center align-items-center m-0 overflow-hidden">
      <div class="col-12"
        style="max-width: 380px">
        <div class="admin-content mb-3">
          <div class="app-branding on-dark justify-content-center flex-column lh-1">
            <img src="<?php echo e(url('assets/images/logo-baru.svg')); ?>"
              alt="Logo"
              class="img-fluid mb-3"
              style="image-rendering: optimizeQuality">
          </div>
          <?php if(isset($_GET['lupa-sandi-success'])): ?>
          <div class="alert alert-success fz-0-9rem mb-0 mt-3">Permintaan reset sandi untuk email anda berhasil dibuat, Silakan cek email untuk instruksi lebih lanjut.</div>
          <?php elseif(isset($_GET['reset-sandi-success'])): ?>
          <div class="alert alert-success fz-0-9rem mb-0 mt-3">Reset Sandi berhasil, silakan login dengan sandi baru anda.</div>
          <?php endif; ?>
          <div class="card card-login"
            style="margin-top: 1.75rem;">
            <div class="card-body pt-3">
              <form action="<?php echo e(route('login.post')); ?>"
                method="POST"
                id="formnya">
                <?php echo csrf_field(); ?>
                <input type="hidden"
                  name="remember"
                  value="1">
                <div class="form-group">
                  <label class="form-label">Nama Pengguna</label>
                  <input type="text"
                    class="form-control"
                    placeholder="Nama Pengguna"
                    name="pengguna"
                    required>
                </div>
                <div class="form-group">
                  <label class="form-label d-flex justify-content-between align-items-center">
                    <span>Kata Sandi</span>
                    <a href="<?php echo e(route('lupa-sandi.index')); ?>"
                      class="fw-700 fz-md"
                      tabindex="-1">Lupa sandi?</a>
                  </label>
                  <input type="password"
                    class="form-control"
                    placeholder="Kata Sandi"
                    name="sandi"
                    required>
                </div>
                <button class="btn btn-block btn-primary is-btn mt-2">
                  <div class="fz-normal">MASUK</div>
                </button>
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
      let tInfo;
      $('input[name="pengguna"]').focus();
      window.fForm = new AKForm("#formnya", {
        form: {
          beforeSubmit: function() {
            tInfo = AKToast.info({
              message: 'Sedang memproses login'
            }, false);
          },
          success: function(res) {
            tInfo.close();
            fForm.reset();
            if (res.success) {
              AKToast.success(res.message);
              if (res.redir) location.href = res.redir;
            }
          },
          error: function(xhr) {
            tInfo.close();
            AKToast.error(xhr.responseJSON.message);
            if (xhr.status == 419) {
              location.reload();
            } else if (xhr.status == 429 && xhr.responseJSON && xhr.responseJSON.error && xhr.responseJSON.error.data && xhr.responseJSON.error.data.wait) {
              stunLoginForm(xhr.responseJSON.error.data);
            } else {
              fForm.parseError(xhr);
            }
          }
        }
      });
      var stunLoginForm = function(res) {
        document.activeElement.blur();
        $('#formnya').addClass('disabled');
        let tunggu = res.wait;
        var itunggu = setInterval(() => {
          let err = {
            pengguna: [res.errors.pengguna[0].replace(/\:\:seconds\:\:/gm, tunggu)]
          };
          fForm.reset();
          fForm.parseError(err);
          if (tunggu <= 0) {
            clearInterval(itunggu);
            $('#formnya').removeClass('disabled');
            fForm.reset();
            $('input[name="pengguna"]').focus();
          } else {
            tunggu--;
          }
        }, 1000);
      };
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /src/resources/views/auth/login.blade.php ENDPATH**/ ?>