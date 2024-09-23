@section('jsBeforeMain')
  <script src="{{ url('libs/anime.min.js') }}"></script>
  <script>
    window.animeGetTarget = function(ani) {
      return ani.children.reduce(
        (all, one) => all.concat(animeGetTarget(one)),
        ani.animatables.map((a) => a.target)
      )
    }

    window.animeCancel = function(ani) {
      animeGetTarget(ani).forEach(anime.remove)
    }
  </script>
  @parent
@endsection