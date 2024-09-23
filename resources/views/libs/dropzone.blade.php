@section('cssBeforeMain')
  <link rel="stylesheet" href="{{ url('libs/dropzone/min/dropzone.min.css') }}">
  @parent
@endsection

@section('jsBeforeMain')
  <script src="{{ url('libs/dropzone/min/dropzone.min.js') }}"></script>
  @parent
@endsection