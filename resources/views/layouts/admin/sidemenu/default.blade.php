<div class="menu-title">Main</div>
<div class="menu-item">
  <a href="{{ route('admin.dasbor.index') }}">
    <i class="mdi mdi-monitor"></i>
    <span>Dasbor</span>
  </a>
</div>

<div class="menu-title">Halaman Default</div>
<div class="menu-item">
  <a href="{{ route('admin.post.index') }}" data-ignore-sub="er">
    <i class="mdi mdi-newspaper-variant"></i>
    <span>Berita</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.announcement.index') }}">
    <i class="mdi mdi-bullhorn"></i>
    <span>Pengumuman</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.agenda.index') }}">
    <i class="mdi mdi-calendar-clock"></i>
    <span>Agenda</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.gallery.index') }}">
    <i class="mdi mdi-image-album"></i>
    <span>Galeri</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.pegawai.index') }}">
    <i class="mdi mdi-card-account-details"></i>
    <span>Pejabat/Pegawai</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.unduhan.index') }}">
    <i class="mdi mdi-file-download"></i>
    <span>Direktori/ Unduhan</span>
    @if (isset($_menuBadge['unduhan_request']) && $_menuBadge['unduhan_request'] > 0)
    <div class="flex"></div>
    <span class="badge badge-light fz-0-75rem">{{ $_menuBadge['unduhan_request'] }}</span>
    @endif
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.faq.index') }}">
    <i class="mdi mdi-message-question"></i>
    <span>FAQ</span>
  </a>
</div>

<div class="menu-title">Halaman Khusus</div>
<div class="menu-item">
  <a href="{{ route('admin.page.index') }}">
    <i class="mdi mdi-file"></i>
    <span>Halaman</span>
  </a>
</div>

<div class="menu-title">Komponen</div>
<div class="menu-item">
  <a href="{{ route('admin.slide.index') }}">
    <i class="mdi mdi-camera-burst"></i>
    <span>Slide</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.poster.index') }}">
    <i class="mdi mdi-tooltip-image-outline"></i>
    <span>Poster</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.link-terkait.index') }}">
    <i class="mdi mdi-link"></i>
    <span>Aplikasi Terkait / Tautan Luar</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.medsos-feed.index') }}">
    <i class="mdi mdi-timeline-text-outline"></i>
    <span>Feed Media Sosial</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.kontak-wa.index') }}">
    <i class="mdi mdi-whatsapp"></i>
    <span>Kontak WA</span>
  </a>
</div>
{{-- <div class="menu-item">
  <a href="{{ route('admin.kontak-form.index') }}">
    <i class="mdi mdi-card-account-phone"></i>
    <span>Kontak Form</span>
  </a>
</div> --}}
<div class="menu-item">
  <a href="{{ route('admin.peta.index') }}">
    <i class="mdi mdi-map-marker-radius"></i>
    <span>Peta</span>
  </a>
</div>

<div class="menu-title">Pengaturan</div>
<div class="menu-item">
  <a href="{{ route('admin.user.index') }}">
    <i class="mdi mdi-account-group"></i>
    <span>Pengguna</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.menu.index') }}">
    <i class="mdi mdi-form-dropdown"></i>
    <span>Menu</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.pengaturan-situs.index') }}">
    <i class="mdi mdi-application-cog-outline"></i>
    <span>Situs</span>
  </a>
</div>
<div class="menu-item">
  <a href="{{ route('admin.pengaturan-akun.index') }}">
    <i class="mdi mdi-account-box"></i>
    <span>Akun</span>
  </a>
</div>

@role('supermin')
<div class="menu-item">
  <a href="{{ route('admin.system-info.index') }}">
    <i class="mdi mdi-book-information-variant"></i>
    <span>System Info</span>
  </a>
</div>
@endrole
