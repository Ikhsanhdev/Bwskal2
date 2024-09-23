<script>
  window.baseurl = `{{ url('') }}`;
</script>

@yield('jsBefore')
<script src="{{ url('libs/jquery.min.js') }}"></script>
<script src="{{ url('libs/smartmenus/jquery.smartmenus.min.js') }}"></script>
<script src="{{ url('libs/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.js') }}"></script>
<script src="{{ url('libs/line-height.js') }}"></script>
<script src="{{ url('libs/jquery.lazy.min.js') }}"></script>
<script src="{{ url('libs/better-scroll/bscroll.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/glightbox@3.0.7/dist/js/glightbox.min.js"></script>

@yield('jsBeforeMain')
<script src="{{ url('libs/aklibs/aklibs.min.js') }}"></script>
<script src="{{ mix('assets/js/web.js') }}"></script>

@yield('jsAfterMain')
@yield('jsAfter')
