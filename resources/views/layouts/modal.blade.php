@if (isset($modalWrapper))
<div {!! $modalWrapper !!}>
@endif
@yield('modalBefore')
@if (isset($formAction) && isset($isEdit))
<form action="{{ $formAction }}"
  method="POST"
  id="{{ $formId ?? 'formnya' }}"
  novalidate
  @if (isset($formType))
  enctype="{{ $formType }}"
  @elseif (isset($formHasFile) && $formHasFile)
  enctype="multipart/form-data"
  @endif
  >
  @if ($isEdit)
  @method('PUT')
  <input type="hidden"
    name="_id"
    value="{{ $data->id }}" />
  @endif
@endif
@hasSection('form')
  @yield('form')
@endif
  <div class="modal-header {{ isset($headerClass) ? $headerClass : '' }}">
    <h5 class="modal-title">@yield('title')</h5>
    @unless(isset($noHeaderClose) && $noHeaderClose)
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
      <i class="mdi mdi-close"></i>
    </button>
    @endunless
  </div>
  <div class="modal-body{{ isset($bodyClass) ? ' ' . $bodyClass : '' }}">
    @yield('body')
  </div>
  @hasSection('footer')
  <div class="modal-footer{{ isset($footerClass) ? ' ' . $footerClass : '' }} flex-nowrap">
    @yield('footer')
  </div>
  @endif
@hasSection('form')
</form>
@endif
@if(isset($formAction) && isset($isEdit))
</form>
@endif
@if (isset($modalWrapper))
</div>
@endif
@yield('script')
