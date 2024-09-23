<header class="main-header">
  <div class="main-nav container">
    <div class="row">
      <div class="col-12 d-flex align-items-center justify-content-between mt-4 my-md-4 flex-column flex-xl-row">
        <div class="branding">
          <a href="<?php echo e(url('/')); ?>" class="flex-shrink-1 flex-md-shrink-0">
            <img src="<?php echo e(url('assets/images/logo-baru.svg')); ?>"
              alt=""
              class="img-fluid"
              width="360px"
              style="image-rendering: optimizeQuality">
          </a>
          <img src="<?php echo e(url('assets/images/cantik-logo.png')); ?>"
            width="90px"
            class="ml-3 logo-cantik">
        </div>
        <div class="nav-menu-search-wrap mt-3 mt-md-4 mt-lg-3 mt-xl-0">
          <div class="main-navbar-wrap">
            <div class="nav-toggler-wrap d-lg-none">
              <button aria-expanded="true" aria-label="Toggle navigation" class="btn btn-light btn-block flex text-dark rounded-0" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                <i class="mdi mdi-menu"></i>
                <span class="">MENU</span>
              </button>
            </div>
            <nav class="navbar px-0 navbar-expand-lg">
              <div class="navbar-collapse w-100 collapse">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.web.mainmenu','data' => []]); ?>
<?php $component->withName('web.mainmenu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
              </div>
            </nav>
          </div>
          <div class="header-search">
            <button class="btn"
              id="header-search-btn">
              <i class="mdi mdi-magnify"></i>
            </button>
            <div class="header-search-popup">
              <form class="web-pencarian"
                method="GET"
                action="<?php echo e(url('pencarian')); ?>">
                <input type="text"
                  name="q"
                  id="header-search-input"
                  placeholder="cari judul berita..."
                  class="form-control fz-0-85rem rounded-0">

                <button class="btn btn-accent rounded-0" type="submit">
                  <i class="mdi mdi-magnify"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<?php /**PATH /src/resources/views/layouts/web/header.blade.php ENDPATH**/ ?>