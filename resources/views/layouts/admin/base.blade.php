<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    @if (isset($title)) {{ $title }} | @else @yield('title', '') @endif {{ config('app.title') }}
  </title>
  @include('layouts.admin.css')
</head>
<body class="admin {!! $bodyClass ?? '' !!}">
  @yield('appBefore')
  <div id="app" class="admin {{ (isset($appClass) ? $appClass : '' ) }}">
    @yield('appContent')
  </div>
  @yield('appAfter')
  <script>
    window.baseurl = `{{ url('') }}`;
  </script>
  @include('layouts.admin.js')
</body>
</html>