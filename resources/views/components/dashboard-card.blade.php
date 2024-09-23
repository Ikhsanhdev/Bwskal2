@props([
  'label',
  'color' => 'bg-white',
  'value' => '',
  'icon' => null,
  ])

@php
switch ($color) {
  case 'bg-primary':
    $colorClass = 'bg-primary text-white';
    break;

  default:
    $colorClass = 'bg-white';
    break;
}
@endphp

<div class="card {{ $colorClass }} mb-3">
  <div class="card-body">
    <div class="d-flex no-block align-items-center">
      <div>
        <h6>{{ $label }}</h6>
        <h2 class="m-0 font-weight-bold">{{ $value }}</h2>
      </div>
      @if ($icon)
      <div class="ml-auto">
        <span class=" display-6"><i class="mdi {{ $icon}} fz-2-5rem"></i></span>
      </div>
      @endif
    </div>
  </div>
</div>
