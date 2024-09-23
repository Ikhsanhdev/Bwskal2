@section('cssBeforeMain')
  <link rel="stylesheet" href="{{ url('libs/select2/select2.min.css') }}">
  @parent
@endsection

@section('jsBeforeMain')
  <script src="{{ url('libs/select2/select2.min.js') }}"></script>
  <script src="{{ url('libs/select2/id.js') }}"></script>
  @parent
@endsection