@props(['item'])

@php
  $_uploadPath = \App\Models\Gallery::UPLOAD_PATH;
@endphp

@switch($item->type)
  @case('album')
    <a class="galeri-card mb-4 mb-lg-5 d-block is-album"
      href="{!! route('gallery.album', ['slug' => $item->slug]) !!}">
      @if ($item->content)
      <img
        src="{{ url($_uploadPath . 'thumbs_' . $item->content) }}"
        class="galeri-thumbs">
      @else
      <div class="galeri-thumbs d-flex justify-content-center align-items-center">
        <i class="mdi mdi-image-album fz-4rem"></i>
      </div>
      @endif
      <div class="album-badge">
        <i class="mdi mdi-image-multiple"></i>
      </div>
      <div class="content-wrap">
        <div class="judul"
          data-maxline="3">{{ $item->name }}</div>
      </div>
    </a>
  @break
  
  @case('image')
  <a class="galeri-card gc-item mb-4 mb-lg-5 d-block"
    href="{{ url($_uploadPath . $item->content) }}"
    data-judul="{{ $item->name }}"
    data-keterangan="{{ $item->description }}"
    data-waktu="{{ $item->created_at->isoFormat('DD MMMM YYYY') }}"
    >
    <img
      src="{{ $item->thumbs_image }}"
      class="galeri-thumbs">
    <div class="content-wrap">
      <div class="judul"
        data-maxline="3">{{ $item->name }}</div>
    </div>
  </a>
  @break

  @case('video')
  <a class="galeri-card gc-item mb-4 mb-lg-5 d-block"
    href="{{ 'https://www.youtube.com/watch?v=' . $item->content }}"
    data-judul="{{ $item->name }}"
    data-keterangan="{{ $item->description }}"
    data-waktu="{{ $item->created_at->isoFormat('DD MMMM YYYY') }}"
    >
    <img
      src="{{ $item->thumbs_image }}"
      class="galeri-thumbs">
    <div class="album-badge">
      <i class="mdi mdi-video"></i>
    </div>
    <div class="content-wrap">
      <div class="judul"
        data-maxline="3">{{ $item->name }}</div>
    </div>
  </a>
  @break
@endswitch
