<ul class="navbar-nav">
@foreach ($menulist as $menu)
@if ($menu->type == "link" || ($menu->type == "default" && !isset($menu->data->type)) || $menu->type == "halaman")
  <li class="nav-item">
    <a class="nav-link" href="{{ parse_href($menu->data) }}" target="{{ parse_target($menu) }}">{{ $menu->text }}</a>
  </li>
@elseif ($menu->type == 'custom' || ($menu->type == "default" && isset($menu->data->type)))
@component('components.menubuilder.' . $menu->data->type, [
  'menu' => $menu,
  'data' => isset($menu->data->data) ? $menu->data->data : [],
  'is_top' => true
])
@endcomponent
@elseif ($menu->type == "dropdown")
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="nav-{{ $menu->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {{ $menu->text }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="nav-{{ $menu->id }}">
@foreach ($menu->data as $submenu)
@include('layouts.menubuilder.submenu-tpl', ['menu' => $submenu])
@endforeach
    </ul>
  </li>
@elseif ($menu->type == "megamenu")
  <li class="nav-item dropdown mega">
    <a class="nav-link dropdown-toggle" href="#" id="nav-{{ str_slug($menu->text) }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {{ $menu->text }}
    </a>
    <div class="dropdown-menu mega-link-list" aria-labelledby="nav-{{ str_slug($menu->text) }}">
      <div class="container"> 
@if ($menu->data->type == 'linklist')
          <div class="row">
@foreach ($menu->data->data as $item)
            <div class="{{ $item->class }}">
              <div class="judul">{{ $item->text }}</div>
              <ul>
@foreach ($item->data as $subitem)
                <li>
                  <a href="{{ parse_href($subitem->data) }}" target="{{ parse_target($subitem) }}">{{ $subitem->text }}</a>
                </li>
@endforeach
              </ul>
            </div>
@endforeach
          </div>
@endif
      </div>
    </div>
  </li>
@endif
@endforeach
</ul>
