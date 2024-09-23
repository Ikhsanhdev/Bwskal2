<div class="dropdown-menu dropdown-menu-right">
  <div class="d-block d-md-none px-3 py-2">
    <div class="fz-normal font-weight-bold">{{ Auth::user()->fullname }}</div>
    <div class="fz-md">{{ Auth::user()->email }}</div>
  </div>
  <a class="dropdown-item" href="{{ url('') }}" target="_blank">
    <i class="icon mdi mdi-home"></i>
    Beranda
  </a>
  <div class="dropdown-divider"></div>
  @role('supermin','admin')
  <a class="dropdown-item" href="{{ route('admin.pengaturan-akun.index') }}">
    <i class="icon mdi mdi-account-box"></i>
    Akun
  </a>
  @else
  <a class="dropdown-item" href="{{ route('me.pengaturan-akun.index') }}">
    <i class="icon mdi mdi-account-box"></i>
    Akun
  </a>
  @endrole
  <a class="dropdown-item" href="https://drive.google.com/drive/folders/1qQO1vJoFaQitkIY2G-Dkb508cP1qtCxc?usp=share_link" target="_blank">
    <i class="icon mdi mdi-notebook"></i>
    Panduan Pengguna
  </a>
  <div class="dropdown-divider"></div>
  <button class="dropdown-item" 
    type="button"
    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
    <i class="icon mdi mdi-logout"></i>
    Keluar
  </button>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
</div>
