<p>Ini adalah email otomatis dari sistem. Mohon untuk tidak membalas email ini. Jika butuh bantuan, silakan hubungi <a href="<?php echo e(url('/')); ?>">Admin Balai Wilayah Sungai Kalimantan II</a>.</p>
<hr>
<?php if($data->status == 'approve'): ?>
<p>Permintaan anda terkait berkas <strong><?php echo e($data->unduhan->title); ?></strong> disetujui oleh Administrator.</p>
<p>Silakan gunakan link berikut untuk mengunduh berkas</p>
<a href="<?php echo e($link); ?>">Unduh Berkas</a>
<?php elseif($data->status == 'reject'): ?>
<p>Mohon maaf permintaan anda terkait berkas <strong><?php echo e($data->unduhan->title); ?></strong> tidak disetujui oleh Administrator.</p>
<?php if($data->admin_message): ?>
<p>Alasan penolakan:<br><?php echo e($data->admin_message); ?></p>
<?php endif; ?>    
<?php endif; ?>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/mail/unduhan-access.blade.php ENDPATH**/ ?>