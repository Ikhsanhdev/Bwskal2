<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @include('layouts.web.meta')
  @include('layouts.web.favicon')
  <title>
    @if (isset($title)) {{ $title }} | @else @yield('title', '') @endif {{ config('app.title') }}
  </title>
  @include('layouts.web.style')
</head>
<body class="web {!! $bodyClass ?? '' !!}">
  @yield('appBefore')
  <div id="app" class="web {{ (isset($appClass) ? $appClass : '' ) }}">
    @yield('appContent')
  </div>
  @yield('appAfter')
  @include('layouts.web.script')
</body>
</html>
