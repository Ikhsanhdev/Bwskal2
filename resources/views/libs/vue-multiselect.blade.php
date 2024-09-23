@php
$_version = '2.1.6';
@endphp

@section('cssBeforeMain')
  <link rel="stylesheet" href="//unpkg.com/vue-multiselect{{ '@' . $_version }}/dist/vue-multiselect.min.css">
  @parent
@endsection

@section('jsAfterMain')
  <script src="//unpkg.com/vue-multiselect{{ '@' . $_version }}/dist/vue-multiselect.min.js"></script>
  @parent
@endsection