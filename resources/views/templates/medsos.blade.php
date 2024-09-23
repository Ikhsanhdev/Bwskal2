@foreach ($list as $item)
<li>
  <a
    href="{{ $item->link }}"
    target="_blank"
    title="{{ $item->name }}"
    class="medsos-link {{ $item->type }}">
    <i class="mdi {{ get_medsos_icon($item->type) }}"></i>
  </a>
</li>
@endforeach
