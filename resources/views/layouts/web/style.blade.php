@yield('cssBefore')
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
<link href="{{ url('libs/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/glightbox@3.0.7/dist/css/glightbox.min.css">
@yield('cssBeforeMain')
<link href="{{ url('libs/aklibs/aklibs.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ mix('assets/css/web.css') }}">
@yield('cssAfterMain')
@yield('cssAfter')
