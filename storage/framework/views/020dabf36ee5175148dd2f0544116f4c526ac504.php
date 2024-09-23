<footer>
  <div class="container">
    <div class="content-wrap">
      <div class="footer-widget footer-profile">
        <div class="footer-logo mb-0 mb-md-4 justify-content-center justify-content-lg-start">
          <div class="logo mb-0 mb-md-4 mb-lg-2">
            <img src="<?php echo e(url('assets/images/logo-baru.svg')); ?>"
              alt="Logo"
              height="46px"
              class="img-fluid"
              style="image-rendering: optimizeQuality">
          </div>
        </div>
        <div class="fz-0-9rem my-3"><?php echo Setting::get('web.profil'); ?></div>
        <a href="<?php echo e(url('profil')); ?>"
          class="btn btn-outline-light font-weight-600 bbbtn rounded-0">SELENGKAPNYA</a>
      </div>
      <div class="footer-widget footer-info2">
        <div class="footer-item">
          <div class="title">Alamat</div>
          <div class="content">
            <div class="mb-lg-0 mb-3"><?php echo Setting::get('web.alamat'); ?></div>
            <?php if(Setting::get('web.google_map')): ?>
              <div class="mt-2">
                <a href="<?php echo Setting::get('web.google_map'); ?>"
                  target="_blank"
                  class="btn btn-outline-light font-weight-600 glb bbbtn rounded-0">LIHAT PETA</a>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="footer-item">
          <?php if(Setting::get('web.kontak_list')): ?>
            <?php
            $__kontakList = json_decode(Setting::get('web.kontak_list'));
            ?>
            <?php if(count($__kontakList)): ?>
                
            <div class="content">
              <div class="title text-accent">Informasi Kontak</div>
              <?php $__currentLoopData = $__kontakList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($item->name); ?>: <?php echo make_footer_kontak_item($item); ?></div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
          <?php endif; ?>
          <?php if(Setting::get('web.telepon')): ?>
            <div class="content">
              <div class="title text-accent">Telepon</div>
              <div><a href="tel:<?php echo normalize_phone(Setting::get('web.telepon')); ?>" class="text-white text-decoration-none fw-700"><?php echo e(Setting::get('web.telepon')); ?></a></div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="footer-widget flex">
        <div class="footer-item">
          <div class="title">Statistik Pengunjung</div>
          <div class="content">
            <div class="subtitle">Hari Ini</div>
            <div><?php echo e(Visitor::getStat()->hari > 0 ? short_number(Visitor::getStat()->hari) . ' Orang' : 'Tidak Ada'); ?></div>
          </div>
          <div class="content">
            <div class="subtitle">Bulan Ini</div>
            <div><?php echo e(Visitor::getStat()->bulan > 0 ? short_number(Visitor::getStat()->bulan) . ' Orang' : 'Tidak Ada'); ?></div>
          </div>
          <div class="content">
            <div class="subtitle">Total</div>
            <div><?php echo e(Visitor::getStat()->total > 0 ? short_number(Visitor::getStat()->total) . ' Orang' : 'Tidak Ada'); ?></div>
          </div>
        </div>
        <div class="footer-item">
          <div class="content">
            <ul class="footer-social">
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.web.medsos-link','data' => []]); ?>
<?php $component->withName('web.medsos-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<div class="footer-cr">
  <div class="container">
    <div class="text">Laman ini dikelola sepenuhnya oleh Balai Wilayah Sungai Kalimantan II</div>
  </div>
</div>
<?php /**PATH /src/resources/views/layouts/web/footer.blade.php ENDPATH**/ ?>