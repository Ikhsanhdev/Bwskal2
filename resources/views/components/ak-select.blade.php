@props([
  'name',
  'label',
  'list' => [],
  'class' => '',
  'wrapperClass' => '',
  'placeholder' => null,
  'id' => null,
  'required' => false,
  'value' => null,
  'sublabel' => null,
  'sublabelPosition' => 'top',
])

<div class="form-group {{ $wrapperClass }}">
  @if (isset($label))
  <label for="" class="{{ isset($sublabel) && $sublabelPosition == 'top' ? 'mb-0' : '' }}">{{ $label }}</label>
  @endif
  @if (isset($sublabel) && $sublabelPosition == 'top')
  <div class="text-muted mb-2 fz-0-8rem">{!! $sublabel !!}</div>
  @endif
  <select 
    @if ($id)
    id="{!! $id !!}"
    @endif
    name="{{ $name }}"
    class="form-control {{ $class }}"
    @if ($required)
    required
    @endif
    {{ $attributes }}
    >
    @if ($placeholder)
    <option value="">{{ $placeholder }}</option>
    @endif
    @if ($list && count($list))
    @foreach ($list as $key => $itemvalue)
      <option value="{{ $key }}" {{ selected_if(isset($value) && $value == $key) }}>{{ $itemvalue }}</option>
    @endforeach
    @elseif ($slot->isNotEmpty())
      {{ $slot }}
    @endif
  </select>
  @if (isset($sublabel) && $sublabelPosition == 'bottom')
  <div class="text-muted mb-2 mt-2 fz-0-8rem">{!! $sublabel !!}</div>
  @endif
</div>
