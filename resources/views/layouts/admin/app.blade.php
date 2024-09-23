@extends('layouts.admin.base')

@section('appContent')
{{-- Sidebar --}}
<div class="modal fade" id="mainaside" role="modal">
  <div class="admin-sidebar modal-dialog">
    <div class="sidebar-header">
      <a href="#" class="logo flex-column lh-1 justify-content-center">
        <img src="{{ url('assets/images/logo-baru.svg') }}"
          alt="Logo"
          class="img-fluid"
          style="image-rendering:crisp-edges">
      </a>
    </div>
    <div class="sidebar-menu bs-scroll" id="smScroll">
      <div class="menu-content">
        @includeFirst(['layouts.admin.sidemenu.' . Auth::user()->role, 'layouts.admin.sidemenu.default'])
      </div>
    </div>
  </div>
</div>
{{-- Container --}}
<div class="admin-container">
  <div class="admin-header">
    <div class="admin-header-title">
      <a href="#" class="d-md-none text-white mr-3" data-toggle="modal" data-target="#mainaside">
        <i class="mdi mdi-menu"></i>
      </a>
      @yield('adminHeader')
    </div>
    <div class="tools">
      <div class="usermenu-wrap dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle" data-display="static" aria-expanded="false">
          <div class="d-none d-md-inline-block text-right mr-3">
            <div class="nama">{{ Auth::user()->fullname }}</div>
            <div class="role">{{ Auth::user()->role_kata }}</div>
          </div>
          <img alt="image" src="{{ Auth::user()->avatar_image }}" class="rounded-circle avatar user-avatar-global img-cover" style="height: 40px">
        </a>
        @includeFirst(['layouts.admin.usermenu.' . Auth::user()->role, 'layouts.admin.usermenu.default'])
      </div>
    </div>
  </div>
  <div class="admin-content">
    @yield('content')
  </div>
  @include('layouts.admin.footer')
</div>
@endsection
