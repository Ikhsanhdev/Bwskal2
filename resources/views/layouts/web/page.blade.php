@extends('layouts.web.base')

@section('appContent')
  @include('layouts.web.topbar')
  @include('layouts.web.header')
  @include('components.web.floating-wa-contact')
  <div class="page-content">
    @yield('content')
  </div>
  @include('layouts.web.footer')
@endsection
