@props([
  'name',
  'label',
  'list' => [],
  'class' => '',
  'id' => null,
  'inline' => true,
  'required' => false,
  'sublabel' => null,
  'sublabelPosition' => 'top',
])

<div class="form-group" 
  @if ($id)
  id="{!! $id !!}"
  @endif
  >
  @if (isset($label))
  <label for="" class="{{ isset($sublabel) && $sublabelPosition == 'top' ? 'mb-0' : '' }}">{{ $label }}</label>
  @endif
  @if (isset($sublabel) && $sublabelPosition == 'top')
  <div class="text-muted mb-2 fz-0-8rem">{!! $sublabel !!}</div>
  @endif
  <div>
    @foreach ($list as $value => $text)
    <div class="form-check {!! $inline ? 'form-check-inline' : '' !!}">
      <label>
        <input class="form-check-input"
          type="radio"
          value="{{ $value }}"
          name="{{ $name }}"
          @if ($required)
          required
          @endif
          {{ $attributes }}
          >
        <span>{{ $text }}</span>
      </label>
    </div>
    @endforeach
  </div>
  @if (isset($sublabel) && $sublabelPosition == 'bottom')
  <div class="text-muted mb-2 mt-2 fz-0-8rem">{!! $sublabel !!}</div>
  @endif
</div>