@extends('layouts.web.app')

@include('libs.owl')
@include('libs.izitoast')

@section('content')
  <section class="home-slider">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="slider-area owl-carousel bg-white px-2 px-md-3 pt-2 pt-md-3"
            id="main-slider">
            @foreach ($slides as $item)
              <div class="slide-item {{ $item->show_title ? '' : 'no-title' }}">
                <img src="{{ url('uploads/' . ($item->type == 'image' ? 'slide' : 'post') . '/' . $item->value) }}"
                  class="slide-image lazy-img">
                @if ($item->link || $item->type == 'post')
                  <a class="owl-item-link"
                    href="{{ $item->type == 'post' ? make_post_link($item) : $item->link }}"
                    target="_blank"></a>
                @endif
                <div class="slide-overlay">
                  @if ($item->type == 'image')
                    @if ($item->show_title)
                      <div class="title"
                        data-maxline="2">{{ $item->title }}</div>
                    @endif
                  @else
                    <div class="kategori-wrap mb-2">
                      <a href="{{ route('post.category', ['slug' => $item->category_slug]) }}"
                        class="kategori">{{ $item->category_name }}</a>
                    </div>
                    <a class="title"
                      href="{{ $item->type == 'post' ? make_post_link($item) : $item->link }}"
                      target="_blank"
                      data-maxline="2">{{ $item->title }}</a>
                    <div class="meta">Diterbitkan oleh <strong>{{ $item->author }}</strong> pada {{ $item->created_at->isoFormat('DD MMMM YYYY') }} | Dilihat <strong>{{ $item->post_hit }}</strong> kali</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white">
    <div class="container pt-4">
      <div class="row">
        <div class="col">
          <div class="web-section-card decor-bt-accent mb-3">
            <div class="section-title mt-3">
              <div class="title">BERITA BALAI</div>
              <div class="flex"></div>
              <div class="action">
                <a href="{{ url('berita') }}"
                  class="btn btn-outline-dark rounded-0 fw-600">SELENGKAPNYA</a>
              </div>
            </div>
            <div class="section-content">
              @if (isset($beritaUtama))
              <div class="row">
                <div class="{{ isset($beritaList) && count($beritaList) ? 'col-lg-6' : 'col' }}">
                  <div class="berita-card mb-lg-0 mb-3">
                    <div class="cover">
                      <a href="{{ make_post_link($beritaUtama) }}"
                        class="cover-img">
                        <img src="{{ $beritaUtama->cover_image }}">
                      </a>
                      <div class="cover-content">
                        <div class="kategori-wrap">
                          <a href="{{ route('post.category', ['slug' => $beritaUtama->category_slug]) }}"
                            class="kategori">{{ $beritaUtama->category_name }}</a>
                        </div>
                        <a class="title"
                          href="{{ make_post_link($beritaUtama) }}"
                          data-maxline="2">{{ $beritaUtama->title }}</a>
                      </div>
                    </div>
                    <div class="isi">{{ \Str::limit(strip_tags($beritaUtama->content), 280) }}</div>
                    <div class="meta">Diterbitkan oleh <span class="font-weight-600">{{ $beritaUtama->author }}</span> pada
                      {{ $beritaUtama->created_at->isoFormat('DD MMMM YYYY') }} | Dilihat <span class="font-weight-600">{{ $beritaUtama->hit_total }}</span> kali</div>
                  </div>
                </div>
                @if (isset($beritaList) && count($beritaList))
                <div class="col-lg-6">
                  <div class="berita-list">
                    @foreach ($beritaList as $berita)
                      <div class="berita-item">
                        <a href="{{ make_post_link($berita) }}"
                          class="berita-link"></a>
                        <div class="cover">
                          <img src="{{ $berita->cover_image }}">
                          <a class="kategori"
                            href="{{ route('post.category', ['slug' => $berita->category_slug]) }}">{{ $berita->category_name }}</a>
                        </div>
                        <div class="tulisan">
                          <div class="title"
                            data-maxline="3">{{ $berita->title }}</div>
                          <div class="flex"></div>
                          <div class="meta">Diterbitkan oleh <span class="font-weight-600">{{ $berita->author }}</span> pada
                            {{ $berita->created_at->isoFormat('DD MMMM YYYY') }}</div>
                          <div class="meta">Dilihat <span class="font-weight-600">{{ $berita->hit_total }}</span> kali</div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
                @endif
              </div>
              @else
              <x-pesan-tengah
                icon="mdi-file-document-edit-outline"
                title="BERITA KOSONG"
                subtitle="Data berita masih belum tersedia"
                />
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-3 mt-md-5 pb-3">
        <div class="col-12 col-md-4 flex">
          <div class="decor-bt-accent pt-3">
            <div class="web-section-card">
              <div class="section-title" style="min-height: 40px">
                <div class="title">BERITA DITJEN SDA</div>
                <div class="flex"></div>
                <div class="action">
                  <a href="{{ route('post.category', ['slug' => \App\Models\PostCategory::DITJEN_SDA_SLUG]) }}"
                    class="btn btn-outline-dark rounded-0 fw-600"
                    >SELENGKAPNYA</a>
                </div>
              </div>
              <div class="section-content berita-ditjen-list">
                @if(isset($beritaDitjenSDA) && count($beritaDitjenSDA))
                @foreach ($beritaDitjenSDA as $item)
                  <a href="{{ make_post_link($item) }}"
                    class="item">
                    <div class="cover">
                      <img src="{{ $item->cover_image }}">
                      <div class="tanggal">{{ $item->created_at->isoFormat('DD MMM') }}</div>
                    </div>
                    <div class="title"
                      data-maxline="4">{{ $item->title }}</div>
                  </a>
                @endforeach
                @else
                <x-pesan-tengah
                  icon="mdi-file-document-edit-outline"
                  title="BERITA KOSONG"
                  subtitle="Data berita masih belum tersedia"
                  />
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-8 d-flex mt-5 mt-md-0">
          <div class="decor-bt-accent w-100 pt-3 d-flex">
            <div class="web-section-card flex w-100 d-flex mb-3 mb-md-0">
              <div class="section-title" style="min-height: 40px">
                <div class="title">POSTER</div>
                <div class="flex"></div>
                <div class="action lh-1">
                  @if ($infografisList && count($infografisList))
                  <i class="mdi fz-2rem mdi-chevron-left is-btn"
                    id="btnInfografisPrev"></i>
                  <i class="mdi fz-2rem mdi-chevron-right is-btn"
                    id="btnInfografisNext"></i>
                  @endif
                </div>
              </div>
              @if ($infografisList && count($infografisList))
              <div class="section-content owl-carousel home-infografis-list d-flex flex w-100"
                id="infografis-slider">
                @foreach ($infografisList as $item)
                  <a href="{{ url(\App\Models\Infografis::UPLOAD_PATH . $item->path) }}"
                    class="gs-item home-infografis-item w-100 lazy-img"
                    style="background-image: url('{{ url(\App\Models\Infografis::UPLOAD_PATH . 'preview_' . $item->path) }}')">
                  </a>
                @endforeach
              </div>
              @else
              <div class="section-content">
                <x-pesan-tengah
                  icon="mdi-tooltip-image-outline"
                  title="POSTER KOSONG"
                  subtitle="Data poster masih belum tersedia"
                  />
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-light-secondary">
    <div class="container py-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex flex-column">
          <div class="web-section-card flex">
            <div class="section-title">
              <div class="title">PENGUMUMAN</div>
            </div>
            <div class="section-content decor-bt-accent d-flex flex-column flex bg-white py-3 px-3 px-md-4">
              @if (isset($announcements) && count($announcements))
              <div class="pengumuman-list flex">
                @foreach ($announcements as $item)
                  <a class="item"
                    href="{{ route('pengumuman.detail', ['slug' => $item->slug]) }}">
                    <img class="cover"
                      src="{{ $item->cover_image }}">
                    <div class="flex">
                      <div class="title"
                        data-maxline="2">{{ $item->title }}</div>
                      <div class="meta">{{ $item->created_at->isoFormat('DD MMMM YYYY') }} | Dilihat {{ $item->hit }} kali</div>
                    </div>
                  </a>
                @endforeach
              </div>
              @else
              <x-pesan-tengah
                icon="mdi-bullhorn"
                title="Pengumuman Kosong"
                subtitle="Data Pengumuman belum ada"
                />
              @endif
              <div class="mt-3 text-center">
                <a href="{{ route('pengumuman.index') }}"
                  class="btn btn-outline-dark rounded-0 fw-600 btn-more">SELENGKAPNYA</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex flex-column">
          <div class="web-section-card flex mt-5 mt-md-0">
            <div class="section-title">
              <div class="title text-uppercase">Agenda Kegiatan</div>
            </div>
            <div class="section-content decor-bt-accent d-flex flex-column flex bg-white py-3 px-3 px-md-4">
              @if (isset($agendaList) && count($agendaList))
              <div class="agenda-list flex">
                @foreach ($agendaList as $item)
                  <a class="item {{ $item->is_active ? 'is-active' : '' }}"
                    href="{{ url('agenda') . '#agenda-' . $item->slug }}">
                    <div class="waktu">
                      <div class="tanggal">{{ $item->begin_at->isoFormat('DD') }}</div>
                      <div class="bulan">{{ $item->begin_at->isoFormat('MMMM') }}</div>
                    </div>
                    <div class="title"
                      data-maxline="2">{{ $item->title }}</div>
                  </a>
                @endforeach
              </div>
              @else
              <x-pesan-tengah
                icon="mdi-calendar-clock"
                title="Agenda Kosong"
                subtitle="Data Agenda belum ada"
                />
              @endif
              <div class="mt-3 text-center">
                <a href="{{ route('web.agenda') }}"
                  class="btn btn-outline-dark rounded-0 fw-600 btn-more">SELENGKAPNYA</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col">
          <div class="web-section-card w-100">
            <div class="section-title">
              <div class="title text-uppercase">GALERI</div>
              <div class="flex"></div>
              <div class="action d-flex">
                <div class="btn is-btn rounded-0 fw-700 bg-accent px-4 btn-gallery"
                  data-type="image"
                  >Foto</div>
                <div class="btn is-btn rounded-0 fw-700 bg-white px-4 btn-gallery"
                  data-type="video"
                  >Video</div>
              </div>
            </div>
            <div class="section-content galeri-section" data-type="image" id="galeri-image-section">
              <div id="galeriFotoSlide"
                class="owl-carousel owl-home-galeri">
                @foreach ($galleryFoto as $item)
                  <a class="galeri-item gs-item"
                    href="{{ url(\App\Models\Gallery::UPLOAD_PATH . $item->content) }}"
                    data-title="{{ $item->name }}"
                    data-description="{{ $item->description }}"
                    data-waktu="{{ $item->created_at->isoFormat('DD MMMM YYYY') }}">
                    <img src="{{ url(\App\Models\Gallery::UPLOAD_PATH . 'thumbs_' . $item->content) }}"
                      loading="lazy">
                    <div class="title"
                      data-maxline="2">{{ $item->name }}</div>
                  </a>
                @endforeach
              </div>
              <div class="mt-3 mt-md-5 text-center">
                @if ($galleryFotoHasMore)
                <a href="#"
                  class="btn btn-outline-dark rounded-0 fw-600 btn-gallery-more" data-type="image">Tampilkan Lebih Banyak</a>
                @else
                <a href="{{ route('gallery.index', ['type' => 'image']) }}"
                  class="btn btn-outline-dark rounded-0 fw-600"
                  id="btn-gallery-foto-selengkapnya">SELENGKAPNYA</a>
                @endif
              </div>
            </div>
            <div class="section-content galeri-section" data-type="video" id="galeri-video-section">
              <div id="galeriVideoSlide"
                class="owl-carousel owl-home-galeri">
                @foreach ($galleryVideo as $item)
                  <a class="galeri-item gs-item"
                    href="{{ 'https://www.youtube.com/watch?v=' . $item->content }}"
                    data-title="{{ $item->name }}"
                    data-description="{{ $item->description }}"
                    data-waktu="{{ $item->created_at->isoFormat('DD MMMM YYYY') }}">
                    <img src="{{ $item->thumbs_image }}"
                      loading="lazy">
                    <div class="title"
                      data-maxline="2">{{ $item->name }}</div>
                    <div class="galeri-badge">
                      <i class="mdi mdi-video"></i>
                    </div>
                  </a>
                @endforeach
              </div>
              <div class="mt-5 text-center">
                @if ($galleryVideoHasMore)
                <a href="#"
                  class="btn btn-outline-dark rounded-0 fw-600 btn-gallery-more" data-type="video">Tampilkan Lebih Banyak</a>
                @else
                <a href="{{ route('gallery.index', ['type' => 'video']) }}"
                  class="btn btn-outline-dark rounded-0 fw-600"
                  id="btn-gallery-video-selengkapnya">SELENGKAPNYA</a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white pt-5 pb-4 overflow-x-hidden">
    <div class="container">
      <div class="row mb-5">
        <div class="col-12">
          <div class="fz-1-5rem fw-700 text-dark mb-4 text-center">APLIKASI & LINK TERKAIT</div>
          @if ($linkTerkaitList && count($linkTerkaitList))
          <div class="owl-carousel owl-link-slider border p-3"
            id="link-slider">
            @foreach ($linkTerkaitList as $item)
              <a class="item"
                href="{{ $item->link }}"
                target="_blank"
                title="{{ $item->name }}">
                <img src="{{ $item->logo_image }}">
              </a>
            @endforeach
          </div>
          @else
          <div class="border p-3">
            <x-pesan-tengah
              icon="mdi-link"
              title="APLIKASI & LINK TERKAIT KOSONG"
              subtitle="Data link masih belum tersedia"
              />
          </div>
          @endif
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-12">
          <div class="fz-1-5rem fw-700 text-dark mb-4 text-center">MEDIA SOSIAL</div>
          <div class="row">
            <div class="col-12 col-md-3">
              @if (Setting::get('medsos-feed.facebook'))
              <div class="d-flex align-items-center justify-content-center">
                <iframe src="https://www.facebook.com/plugins/page.php?href={!! urlencode(Setting::get('medsos-feed.facebook')) !!}&tabs=timeline&width=300&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false"
                  height="500"
                  style="width:100%;border:none;overflow:hidden"
                  scrolling="no"
                  frameborder="0"
                  allowfullscreen="true"
                  allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
              </div>
              @endif
            </div>
            <div class="col-12 col-md-6">
              <div class="d-flex align-items-center justify-content-center h-100 py-5 py-md-0"
                style="min-height: 300px">
                @includeIf('components.web.ig-feed')
              </div>
            </div>
            <div class="col-12 col-md-3">
              @if (Setting::get('medsos-feed.twitter'))
              <div class="d-flex align-items-center justify-content-center">
                <a class="twitter-timeline" data-height="500" data-width="100%" data-dnt="true" href="{{ Setting::get('medsos-feed.twitter') }}?ref_src=twsrc%5Etfw">Tweets by pupr_sda_bwsk2</a>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('jsAfter')
  <script>
    $(function() {
      var $owl = $('#main-slider').owlCarousel({
        items: 1,
        loop: true,
        nav: false,
        dots: true,
        autoplay: true,
        margin: 20,
        autoplayHoverPause: true,
        smartSpeed: 500,
        autoplayTimeout: 8000,
        lazyLoad: true,
      });

      if ($('#infografis-slider').length) {
        var $infografisSlider = $('#infografis-slider').owlCarousel({
          items: 1,
          loop: true,
          nav: false,
          dots: true,
          autoplay: true,
          margin: 20,
          autoplayHoverPause: true,
          smartSpeed: 500,
          autoplayTimeout: 8000,
          lazyLoad: true,
        });
        $('#btnInfografisPrev').on('click', function(e) {
          e.preventDefault();
          $infografisSlider.trigger('prev.owl.carousel');
          console.log('prev');
        });
        $('#btnInfografisNext').on('click', function(e) {
          e.preventDefault();
          $infografisSlider.trigger('next.owl.carousel');
          console.log('next');
        });
      }

      if ($('#link-slider').length) {
        var $owlLink = $(`#link-slider`).owlCarousel({
          items: 1,
          loop: true,
          nav: true,
          navText: [
            `<i class="mdi mdi-chevron-left lh-1 fz-1-5rem"></i>`,
            `<i class="mdi mdi-chevron-right lh-1 fz-1-5rem "></i>`,
          ],
          dots: false,
          autoplay: true,
          margin: 20,
          lazyLoad: true,
          responsive: {
            0: {
              items: 1,
            },
            500: {
              items: 5,
            },
          },
        });
      }

      let $galeriFotoOwl = $('#galeriFotoSlide').owlCarousel({
        items: 1,
        loop: true,
        nav: false,
        dots: true,
        autoplay: false,
        margin:20,
        lazyLoad: true,
        center: true,
        responsive:{
          0:{
            items: 1,
          },
          768:{
            items: 2,
          },
          992:{
            items: 5,
            dots: false,
          }
        },
      });

      let $galeriVideoOwl = $('#galeriVideoSlide').owlCarousel({
        items: 1,
        loop: true,
        nav: false,
        dots: true,
        autoplay: false,
        margin:20,
        lazyLoad: true,
        center: true,
        responsive:{
          0:{
            items: 1,
          },
          768:{
            items: 2,
          },
          992:{
            items: 5,
            dots: false,
          }
        },
      });

      window.gb = GLightbox({
        elements: [],
      });

      function handleGsitem(e) {
        e.preventDefault();
        let gdata = {
          title: e.currentTarget.dataset.title,
          description: e.currentTarget.dataset.description ?? '',
          waktu: e.currentTarget.dataset.waktu ?? '',
        };
        console.log(gdata);
        gb.settings.slideHTML = `<div class="gslide">
      <div class="gslide-inner-content">
          <div class="ginner-container">
              <div class="gslide-media">
                <div class="gslide-captionnya ${gdata.title == undefined ? 'd-none' : ''}">
                  <div class="title">${gdata.title}</div>
                  ${gdata.description ? '<div class="keterangan">' + gdata.description+ '</div>' : ''}
                  ${gdata.waktu ? '<div class="waktu">' + gdata.waktu + '</div>' : ''}
                </div>
              </div>
          </div>
      </div>
  </div>`;
        gb.setElements([{ href: this.href }]);
        gb.open();
      }

      $('.home-infografis-list').on('click', '.gs-item', handleGsitem);
      $('.galeri-section').on('click', '.gs-item', handleGsitem);
      $('.galeri-section[data-type="video"]').fadeOut(0);
      $(`.btn-gallery`).on('click', function () {
        $(`.btn-gallery`).removeClass('bg-accent').addClass('bg-white');
        $(`.btn-gallery[data-type="${this.dataset.type}"]`).removeClass('bg-white').addClass('bg-accent');
        $(`.galeri-section`).fadeOut(0);
        $(`.galeri-section[data-type="${this.dataset.type}"]`).fadeIn(0);
      });
    });
  </script>
@endsection
