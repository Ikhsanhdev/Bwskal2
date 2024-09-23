@section('cssBeforeMain')
  <link rel="stylesheet" href="{{ url('libs/owlcarousel/assets/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ url('libs/owlcarousel/assets/owl.theme.default.min.css') }}">
  @parent
@endsection

@section('jsBeforeMain')
  <script src="{{ url('libs/owlcarousel/owl.carousel.min.js') }}"></script>
  @parent
@endsection