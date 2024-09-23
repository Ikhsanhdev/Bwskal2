@extends('layouts.web.page')

@php
  $title = 'Galeri ' . ucfirst($type);
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">GALERI</div>
            <div class="side-title">({!! info_paginate($list, "Item") !!}</strong>)</div>
          </div>
          <div class="flex"></div>
          <div class="d-flex align-items-center">
            @if ($type == 'image')
            <div class="btn is-btn rounded-0 fw-700 bg-accent px-4 btn-gallery"
              >Foto</div>
            <a class="btn is-btn rounded-0 fw-700 bg-white px-4 btn-gallery"
              href="{{ route('gallery.index', ['type' => 'video']) }}"
              >Video</a>
            @else
            <a class="btn is-btn rounded-0 fw-700 bg-white px-4 btn-gallery"
              href="{{ route('gallery.index', ['type' => 'image']) }}"
              >Foto</a>
            <div class="btn is-btn rounded-0 fw-700 bg-accent px-4 btn-gallery"
              >Video</div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent pt-3 pt-md-5">
      @if ($list && count($list))
        <div class="row">
          @foreach ($list as $item)
            <div class="col-md-6 col-lg-3">
              <x-web.gallery-item :item="$item" />
            </div>
          @endforeach
        </div>
        @if (isset($list) && $list->total() > $list->perPage())
          <div class="d-flex justify-content-center">
            {{ $list->links() }}
          </div>
        @endif
      @else
        <x-pesan-tengah icon="mdi-file-document-edit-outline"
          :title="$title . ' Kosong'" />
      @endif
    </div>
  </div>
@endsection

@section('jsAfterMain')
<script>
  $(document).ready(function () {
    window.gb = GLightbox({
      elements: [],
    });
    $('.gc-item').on('click', function (e) {
      e.preventDefault();
      let gdata = {
        judul: this.dataset.judul,
        keterangan: this.dataset.keterangan ?? '',
        waktu: this.dataset.waktu ?? '',
      };
      gb.settings.slideHTML = `<div class="gslide">
    <div class="gslide-inner-content">
        <div class="ginner-container">
            <div class="gslide-media">
              <div class="gslide-captionnya">
                <div class="title">${gdata.judul}</div>
                ${gdata.keterangan? '<div class="keterangan">' + gdata.keterangan+ '</div>' : ''}
                ${gdata.waktu ? '<div class="waktu">' + gdata.waktu + '</div>' : ''}
              </div>
            </div>
        </div>
    </div>
</div>`;
      gb.setElements([{ href: this.href }]);
      gb.open();
    });
  });
</script>
@endsection
