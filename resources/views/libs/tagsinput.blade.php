@section('cssBeforeMain')
  <link rel="stylesheet" href="{{ url('libs/tagsinput/tagsinput.css') }}">
  @parent
@endsection

@section('jsBeforeMain')
  <script src="{{ url('libs/tagsinput/tagsinput.js') }}"></script>
  @parent
@endsection