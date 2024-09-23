<?php if(isset($modalWrapper)): ?>
<div <?php echo $modalWrapper; ?>>
<?php endif; ?>
<?php echo $__env->yieldContent('modalBefore'); ?>
<?php if(isset($formAction) && isset($isEdit)): ?>
<form action="<?php echo e($formAction); ?>"
  method="POST"
  id="<?php echo e($formId ?? 'formnya'); ?>"
  novalidate
  <?php if(isset($formType)): ?>
  enctype="<?php echo e($formType); ?>"
  <?php elseif(isset($formHasFile) && $formHasFile): ?>
  enctype="multipart/form-data"
  <?php endif; ?>
  >
  <?php if($isEdit): ?>
  <?php echo method_field('PUT'); ?>
  <input type="hidden"
    name="_id"
    value="<?php echo e($data->id); ?>" />
  <?php endif; ?>
<?php endif; ?>
<?php if (! empty(trim($__env->yieldContent('form')))): ?>
  <?php echo $__env->yieldContent('form'); ?>
<?php endif; ?>
  <div class="modal-header <?php echo e(isset($headerClass) ? $headerClass : ''); ?>">
    <h5 class="modal-title"><?php echo $__env->yieldContent('title'); ?></h5>
    <?php if (! (isset($noHeaderClose) && $noHeaderClose)): ?>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
      <i class="mdi mdi-close"></i>
    </button>
    <?php endif; ?>
  </div>
  <div class="modal-body<?php echo e(isset($bodyClass) ? ' ' . $bodyClass : ''); ?>">
    <?php echo $__env->yieldContent('body'); ?>
  </div>
  <?php if (! empty(trim($__env->yieldContent('footer')))): ?>
  <div class="modal-footer<?php echo e(isset($footerClass) ? ' ' . $footerClass : ''); ?> flex-nowrap">
    <?php echo $__env->yieldContent('footer'); ?>
  </div>
  <?php endif; ?>
<?php if (! empty(trim($__env->yieldContent('form')))): ?>
</form>
<?php endif; ?>
<?php if(isset($formAction) && isset($isEdit)): ?>
</form>
<?php endif; ?>
<?php if(isset($modalWrapper)): ?>
</div>
<?php endif; ?>
<?php echo $__env->yieldContent('script'); ?>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/layouts/modal.blade.php ENDPATH**/ ?>