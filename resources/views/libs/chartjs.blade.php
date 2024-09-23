@section('cssBeforeMain')
  <link rel="stylesheet" href="{{ url('libs/chartjs/Chart.min.css') }}">
  @parent
@endsection

@section('jsBeforeMain')
  <script src="{{ url('libs/chartjs/Chart.min.js') }}"></script>
  @if (isset($colorScheme) && $colorScheme)
  <script src="{{ url('libs/chartjs/chartjs-plugin-colorschemes.min.js') }}"></script>
  @endif
  @parent
@endsection