<ul class="navbar-nav">
<?php $__currentLoopData = $menulist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($menu->type == "link" || ($menu->type == "default" && !isset($menu->data->type)) || $menu->type == "halaman"): ?>
  <li class="nav-item">
    <a class="nav-link" href="<?php echo e(parse_href($menu->data)); ?>" target="<?php echo e(parse_target($menu)); ?>"><?php echo e($menu->text); ?></a>
  </li>
<?php elseif($menu->type == 'custom' || ($menu->type == "default" && isset($menu->data->type))): ?>
<?php $__env->startComponent('components.menubuilder.' . $menu->data->type, [
  'menu' => $menu,
  'data' => isset($menu->data->data) ? $menu->data->data : [],
  'is_top' => true
]); ?>
<?php echo $__env->renderComponent(); ?>
<?php elseif($menu->type == "dropdown"): ?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="nav-<?php echo e($menu->id); ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php echo e($menu->text); ?>

    </a>
    <ul class="dropdown-menu" aria-labelledby="nav-<?php echo e($menu->id); ?>">
<?php $__currentLoopData = $menu->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->make('layouts.menubuilder.submenu-tpl', ['menu' => $submenu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </li>
<?php elseif($menu->type == "megamenu"): ?>
  <li class="nav-item dropdown mega">
    <a class="nav-link dropdown-toggle" href="#" id="nav-<?php echo e(str_slug($menu->text)); ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php echo e($menu->text); ?>

    </a>
    <div class="dropdown-menu mega-link-list" aria-labelledby="nav-<?php echo e(str_slug($menu->text)); ?>">
      <div class="container"> 
<?php if($menu->data->type == 'linklist'): ?>
          <div class="row">
<?php $__currentLoopData = $menu->data->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="<?php echo e($item->class); ?>">
              <div class="judul"><?php echo e($item->text); ?></div>
              <ul>
<?php $__currentLoopData = $item->data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <a href="<?php echo e(parse_href($subitem->data)); ?>" target="<?php echo e(parse_target($subitem)); ?>"><?php echo e($subitem->text); ?></a>
                </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
<?php endif; ?>
      </div>
    </div>
  </li>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /var/www/sda/balai/bwskalimantan2/resources/views/layouts/menubuilder/menu-tpl.blade.php ENDPATH**/ ?>