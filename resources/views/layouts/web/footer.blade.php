<footer>
  <div class="container">
    <div class="content-wrap">
      <div class="footer-widget footer-profile">
        <div class="footer-logo mb-0 mb-md-4 justify-content-center justify-content-lg-start">
          <div class="logo mb-0 mb-md-4 mb-lg-2">
            <img src="{{ url('assets/images/logo-baru.svg') }}"
              alt="Logo"
              height="46px"
              class="img-fluid"
              style="image-rendering: optimizeQuality">
          </div>
        </div>
        <div class="fz-0-9rem my-3">{!! Setting::get('web.profil') !!}</div>
        <a href="{{ url('profil') }}"
          class="btn btn-outline-light font-weight-600 bbbtn rounded-0">SELENGKAPNYA</a>
      </div>
      <div class="footer-widget footer-info2">
        <div class="footer-item">
          <div class="title">Alamat</div>
          <div class="content">
            <div class="mb-lg-0 mb-3">{!! Setting::get('web.alamat') !!}</div>
            @if (Setting::get('web.google_map'))
              <div class="mt-2">
                <a href="{!! Setting::get('web.google_map') !!}"
                  target="_blank"
                  class="btn btn-outline-light font-weight-600 glb bbbtn rounded-0">LIHAT PETA</a>
              </div>
            @endif
          </div>
        </div>
        <div class="footer-item">
          @if (Setting::get('web.kontak_list'))
            @php
            $__kontakList = json_decode(Setting::get('web.kontak_list'));
            @endphp
            @if (count($__kontakList))
                
            <div class="content">
              <div class="title text-accent">Informasi Kontak</div>
              @foreach ($__kontakList as $item)
                <div>{{ $item->name }}: {!! make_footer_kontak_item($item) !!}</div>
              @endforeach
            </div>
            @endif
          @endif
          @if (Setting::get('web.telepon'))
            <div class="content">
              <div class="title text-accent">Telepon</div>
              <div><a href="tel:{!! normalize_phone(Setting::get('web.telepon')) !!}" class="text-white text-decoration-none fw-700">{{ Setting::get('web.telepon') }}</a></div>
            </div>
          @endif
        </div>
      </div>
      <div class="footer-widget flex">
        <div class="footer-item">
          <div class="title">Statistik Pengunjung</div>
          <div class="content">
            <div class="subtitle">Hari Ini</div>
            <div>{{ Visitor::getStat()->hari > 0 ? short_number(Visitor::getStat()->hari) . ' Orang' : 'Tidak Ada' }}</div>
          </div>
          <div class="content">
            <div class="subtitle">Bulan Ini</div>
            <div>{{ Visitor::getStat()->bulan > 0 ? short_number(Visitor::getStat()->bulan) . ' Orang' : 'Tidak Ada' }}</div>
          </div>
          <div class="content">
            <div class="subtitle">Total</div>
            <div>{{ Visitor::getStat()->total > 0 ? short_number(Visitor::getStat()->total) . ' Orang' : 'Tidak Ada' }}</div>
          </div>
        </div>
        <div class="footer-item">
          <div class="content">
            <ul class="footer-social">
              <x-web.medsos-link />
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<div class="footer-cr">
  <div class="container">
    <div class="text">Laman ini dikelola sepenuhnya oleh Balai Wilayah Sungai Kalimantan II</div>
  </div>
</div>
