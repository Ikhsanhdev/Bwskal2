@props([
  'label',
  'target',
  'icon' => 'mdi-file',
  'show' => false,
  ])

<div>
  <div class="ak1-title-collapsable"
    data-toggle="collapse"
    data-target="#{!! $target !!}"
    {!! $show ? 'aria-expanded="true"' : '' !!}
    >
    <i class="mdi {!! $icon !!} fz-2rem mr-3"></i>
    <div class="lh-1">
      <div class="fw-700 fz-1-15rem">{{ $label }}</div>
    </div>
    <div class="flex"></div>
    <i class="mdi mdi-chevron-down indicator"></i>
  </div>
  <div class="ak1-section-content collapse {!! $show ? 'show' : '' !!}" id="{!! $target !!}">
    {{ $slot }}
  </div>
</div>
