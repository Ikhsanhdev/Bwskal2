@extends('layouts.web.page')

@php
  $title = $data->title;
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">DETAIL BERITA</div>
          </div>
          <div class="flex"></div>
          <div class="fz-0-85rem text-center text-md-left d-flex flex-column flex-md-row">
            <div>
              Diterbitkan oleh <span class="fw-700">{{ $data->author }}</span> pada <span class="fw-700">{{ $data->created_at->isoFormat('DD MMMM YYYY') }}</span>
            </div>
            <div class="d-none d-md-block px-1">|</div>
            <div>Dilihat {{ $data->hit_total }} kali</div>
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-box px-0 pt-0">
      <div class="web-post-cover">
        <img src="{{ $data->cover_image }}"
          class="web-post-cover-img">
        <div class="web-post-cover-content">
          <div class="kategori-wrap">
            <a href="{{ route('post.category', ['slug' => $data->category_slug]) }}"
              class="kategori">{{ $data->category_name }}</a>
          </div>
          <div class="title"
            data-maxline="5">{{ $data->title }}</div>
        </div>
      </div>
      <div class="page-text-content ck-content">
        {!! $data->content !!}
      </div>
    </div>
  </div>
@endsection
