<?php if(Setting::get('floating-wa.telepon')): ?>
  <div class="floating-wa-contact" id="floating-wa-contact">
    <?php if(Setting::get('floating-wa.foto') && Setting::get('floating-wa.nama') && Setting::get('floating-wa.pesan')): ?>
    <div class="window">
      <div class="header">
        <div class="avatar">
          <img src="<?php echo e(url('uploads/avatar/' . Setting::get('floating-wa.foto'))); ?>"
            alt="">
        </div>
        <div class="header-info">
          <div class="name"><?php echo e(Setting::get('floating-wa.nama')); ?></div>
          <?php if(Setting::get('floating-wa.keterangan')): ?>
          <div class="subtitle"><?php echo e(Setting::get('floating-wa.keterangan')); ?></div>
          <?php endif; ?>
        </div>
        <div class="close-btn">
          <i class="mdi mdi-close"></i>
        </div>
      </div>
      <div class="body">
        <div class="chat-item">
          <div class="loading">
            <i class="mdi mdi-spin mdi-loading fz-1-15rem"></i>
          </div>
          <div class="content">
            <div class="name"><?php echo e(Setting::get('floating-wa.nama')); ?></div>
            <div class="message">
              <?php echo Setting::get('floating-wa.pesan'); ?>

            </div>
            <div class="time">15:28</div>
          </div>
        </div>
      </div>
      <div class="footer">
        <form method="POST" class="w-100" data-phone="<?php echo Setting::get('floating-wa.telepon'); ?>">
          <input type="text"
            class="form-control mr-3"
            placeholder="Masukkan pesan...">
          <button type="submit" class="btn btn-secondary">
            <i class="mdi mdi-send"></i>
          </button>
        </form>
      </div>
    </div>
    <div class="wa-btn">
      <i class="mdi mdi-whatsapp"></i>
    </div>
    <?php else: ?>
    <a href="https://wa.me/<?php echo Setting::get('floating-wa.telepon'); ?>"
      target="_blank"
      class="wa-btn">
      <i class="mdi mdi-whatsapp"></i>
    </a>
    <?php endif; ?>
  </div>
<?php endif; ?>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/components/web/floating-wa-contact.blade.php ENDPATH**/ ?>