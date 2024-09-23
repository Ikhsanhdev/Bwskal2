@extends('layouts.web.base')

@section('appContent')
  @include('layouts.web.topbar')
  @include('layouts.web.header')
  @include('components.web.floating-wa-contact')
  @yield('content')
  @include('layouts.web.footer')
@endsection
