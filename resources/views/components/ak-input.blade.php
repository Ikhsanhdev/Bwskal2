@props([
  'name',
  'label',
  'placeholder',
  'data',
  'id' => null,
  'class' => '',
  'type' => 'text',
  'required' => false,
  'value' => null,
  'sublabel' => null,
  'sublabelPosition' => 'top',
  'autocomplete' => 'off',
  'optional' => false,
  ])

<div class="form-group">
  @if (isset($label))
  <label for="" class="{{ isset($sublabel) && $sublabelPosition == 'top' ? 'mb-0' : '' }}">{!! $label !!} {!! $optional ? '<span class="fz-0-75rem text-muted fw-600">(Opsional)</span>' : '' !!}</label>
  @endif
  @if (isset($sublabel) && $sublabelPosition == 'top')
  <div class="text-muted mb-2 fz-0-8rem">{!! $sublabel !!}</div>
  @endif
  @if ($type == 'textarea')
  <textarea
    @if ($id)
    id="{!! $id !!}"
    @endif
    name="{{ $name }}"
    type="{!! $type !!}"
    class="form-control {{ $class }}"
    placeholder="{{ isset($placeholder) ? ($placeholder == '$label' && isset($label) ? $label : $placeholder) : Str::title($name) }}"
    @if ($required)
    required
    @endif
    {{ $attributes }}
    >@if(isset($data) && !isset($value) && isset($data->{$name})){{ $data->{$name} }}@else{{ $value ?? '' }}@endif</textarea>
  @else
  <input
    @if ($id)
    id="{!! $id !!}"
    @endif
    name="{{ $name }}"
    type="{!! $type !!}"
    class="form-control {{ $class }}"
    autocomplete="{{ $autocomplete }}"
    placeholder="{{ isset($placeholder) ? ($placeholder == '$label' && isset($label) ? $label : $placeholder) : Str::title($name) }}"
    @if ($required)
    required
    @endif
    {{ $attributes }}
    @if (isset($data) && !isset($value) && isset($data->{$name}))
    value="{{ $data->{$name} }}"
    @else
    value="{{ $value ?? '' }}"
    @endif
    >
  @endif
  @if (isset($sublabel) && $sublabelPosition == 'bottom')
  <div class="text-muted mb-2 mt-2 fz-0-8rem">{!! $sublabel !!}</div>
  @endif
</div>
