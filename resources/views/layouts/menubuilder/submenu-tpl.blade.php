@if ($menu->type == "link" || ($menu->type == "default" && !isset($menu->data->type)) || $menu->type == "halaman")
      <li class="">
        <a class="dropdown-item" href="{{ parse_href($menu->data) }}" target="{{ parse_target($menu) }}">{{ $menu->text }}</a>
      </li>
@elseif ($menu->type == 'custom' || ($menu->type == "default" && isset($menu->data->type)))
@component('components.menubuilder.' . $menu->data->type, [
  'menu' => $menu,
  'data' => isset($menu->data->data) ? $menu->data->data : [],
])
@endcomponent
@elseif ($menu->type == "dropdown")
      <li class="dropdown">
        <a class="dropdown-item has-submenu" href="#" id="nav-{{ $menu->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          {{ $menu->text }}
        </a>
        <ul class="dropdown-menu" aria-labelledby="nav-{{ $menu->id }}">
@foreach ($menu->data as $submenu)
@include('layouts.menubuilder.submenu-tpl', ['menu' => $submenu])
@endforeach
    </ul>
  </li>
@endif
