@section('cssBeforeMain')
  <link rel="stylesheet" href="//unpkg.com/smartphoto@1.1.0/css/smartphoto.min.css">
  <style>.smartphoto {background-color: rgba(0, 0, 0, 0.85)}.smartphoto-nav ul {overflow-x: auto}</style>
  @parent
@endsection

@section('jsBeforeMain')
  <script src="//unpkg.com/smartphoto@1.1.0/js/smartphoto.min.js"></script>
  @parent
@endsection