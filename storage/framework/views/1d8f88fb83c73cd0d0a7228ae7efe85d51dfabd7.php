<?php if($menu->type == "link" || ($menu->type == "default" && !isset($menu->data->type)) || $menu->type == "halaman"): ?>
      <li class="">
        <a class="dropdown-item" href="<?php echo e(parse_href($menu->data)); ?>" target="<?php echo e(parse_target($menu)); ?>"><?php echo e($menu->text); ?></a>
      </li>
<?php elseif($menu->type == 'custom' || ($menu->type == "default" && isset($menu->data->type))): ?>
<?php $__env->startComponent('components.menubuilder.' . $menu->data->type, [
  'menu' => $menu,
  'data' => isset($menu->data->data) ? $menu->data->data : [],
]); ?>
<?php echo $__env->renderComponent(); ?>
<?php elseif($menu->type == "dropdown"): ?>
      <li class="dropdown">
        <a class="dropdown-item has-submenu" href="#" id="nav-<?php echo e($menu->id); ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo e($menu->text); ?>

        </a>
        <ul class="dropdown-menu" aria-labelledby="nav-<?php echo e($menu->id); ?>">
<?php $__currentLoopData = $menu->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->make('layouts.menubuilder.submenu-tpl', ['menu' => $submenu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </li>
<?php endif; ?>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/layouts/menubuilder/submenu-tpl.blade.php ENDPATH**/ ?>