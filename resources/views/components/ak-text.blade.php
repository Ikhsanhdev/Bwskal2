@props([
  'label',
  'value' => null,
  'class' => '',
  ])

<div class="form-group">
  @if (isset($label))
  <label for="">{{ $label }}</label>
  @endif
  <div
    class="form-control h-auto {!! $class !!}"
    {{ $attributes }}
    >
    {{ $value ?? '' }}
    </div>
</div>