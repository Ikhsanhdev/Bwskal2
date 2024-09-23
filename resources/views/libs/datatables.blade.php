@section('cssBeforeMain')
  <link rel="stylesheet" href="{{ url('libs/datatables/datatables.min.css') }}">
  @parent
@endsection

@section('jsBeforeMain')
  <script src="{{ url('libs/datatables/datatables.min.js') }}"></script>
  @parent
@endsection