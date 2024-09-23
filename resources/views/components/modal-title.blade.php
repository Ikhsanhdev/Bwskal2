@props([
  'title',
  'titleSize' => 'fz-1rem',
  'icon' => null,
  'iconSize' => 'fz-2-25rem',
  'subtitle' => null,
  'class' => '',
])

<div class="d-flex align-items-center {!! $class !!}">
  @if (isset($icon))
  <i class="mdi {{ $icon }} {{ $iconSize }} mr-3"></i>
  @endif
  <div>
    <div class="font-weight-bold {{ $titleSize }}">{!! $title !!}</div>
    @if (isset($subtitle))
    <div class="fz-md">{!! $subtitle !!}</div>
    @endif
  </div>
</div>