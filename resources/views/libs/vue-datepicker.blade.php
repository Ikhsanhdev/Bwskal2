@php
$_version = '3.4.1';
@endphp

@section('cssBeforeMain')
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/vue2-datepicker{{ '@' . $_version }}/index.css">
  @parent
@endsection

@section('jsAfterMain')
  <script src="//cdn.jsdelivr.net/npm/vue2-datepicker{{ '@' . $_version }}/index.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/vue2-datepicker{{ '@' . $_version }}/locale/id.min.js"></script>
  @parent
@endsection