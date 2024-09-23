<?php $__env->startSection('appContent'); ?>

<div class="modal fade" id="mainaside" role="modal">
  <div class="admin-sidebar modal-dialog">
    <div class="sidebar-header">
      <a href="#" class="logo flex-column lh-1 justify-content-center">
        <img src="<?php echo e(url('assets/images/logo-baru.svg')); ?>"
          alt="Logo"
          class="img-fluid"
          style="image-rendering:crisp-edges">
      </a>
    </div>
    <div class="sidebar-menu bs-scroll" id="smScroll">
      <div class="menu-content">
        <?php echo $__env->first(['layouts.admin.sidemenu.' . Auth::user()->role, 'layouts.admin.sidemenu.default'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
    </div>
  </div>
</div>

<div class="admin-container">
  <div class="admin-header">
    <div class="admin-header-title">
      <a href="#" class="d-md-none text-white mr-3" data-toggle="modal" data-target="#mainaside">
        <i class="mdi mdi-menu"></i>
      </a>
      <?php echo $__env->yieldContent('adminHeader'); ?>
    </div>
    <div class="tools">
      <div class="usermenu-wrap dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle" data-display="static" aria-expanded="false">
          <div class="d-none d-md-inline-block text-right mr-3">
            <div class="nama"><?php echo e(Auth::user()->fullname); ?></div>
            <div class="role"><?php echo e(Auth::user()->role_kata); ?></div>
          </div>
          <img alt="image" src="<?php echo e(Auth::user()->avatar_image); ?>" class="rounded-circle avatar user-avatar-global img-cover" style="height: 40px">
        </a>
        <?php echo $__env->first(['layouts.admin.usermenu.' . Auth::user()->role, 'layouts.admin.usermenu.default'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
    </div>
  </div>
  <div class="admin-content">
    <?php echo $__env->yieldContent('content'); ?>
  </div>
  <?php echo $__env->make('layouts.admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/layouts/admin/app.blade.php ENDPATH**/ ?>