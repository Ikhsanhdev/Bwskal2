<div class="akbox">
  <div class="content {{ isset($padding) ? $padding : 'p-5' }} d-flex flex-column text-center text-dark">
    <div class="mb-3">
      <i class="mdi {{ isset($icon) ? $icon : 'mdi-cloud-off-outline' }} fz-5rem"></i>
    </div>
    <div class="fz-xl fw-700">{{ $title }}</div>
    @if (isset($subtitle))
    <div class="fz-normal">{!! $subtitle !!}</div>
    @endif
  </div>
</div>
