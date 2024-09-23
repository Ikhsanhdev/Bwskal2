@php
$_version = '1.9.6';
@endphp

@section('jsBeforeMain')
  <script src="//cdn.jsdelivr.net/npm/dayjs{{ '@' . $_version }}/dayjs.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/dayjs{{ '@' . $_version }}/locale/id.js"></script>
  @parent
@endsection