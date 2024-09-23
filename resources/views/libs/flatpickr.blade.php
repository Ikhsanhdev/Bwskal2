@section('cssBeforeMain')
  <link href="//cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
  @parent
@endsection

@section('jsBeforeMain')
  <script src="//cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="//cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.min.js"></script>
  <script>
    flatpickr.localize(flatpickr.l10ns.id);
  </script>
  @parent
@endsection