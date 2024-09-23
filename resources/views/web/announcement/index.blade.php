@extends('layouts.web.page')

@php
  $title = 'Pengumuman';
@endphp

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="page-top-wrap">
          <div class="page-title-wrap">
            <div class="title">PENGUMUMAN</div>
            <div class="side-title">({!! info_paginate($list, 'Pengumuman') !!})</div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-box decor-bt-accent">
      @if ($list && count($list))
        <div class="row">
          @foreach ($list as $item)
            <div class="col-md-6">
              <div class="berita-card {{ $loop->iteration > 2 ? 'mt-md-5' : '' }}">
                <div class="cover mini">
                  <a href="{{ route('pengumuman.detail', ['slug' => $item->slug]) }}"
                    class="cover-img">
                    <img src="{{ $item->cover_image }}">
                  </a>
                  <div class="cover-content pb-4">
                    <a class="title fz-1-25rem"
                      data-maxline="3"
                      href="{{ route('pengumuman.detail', ['slug' => $item->slug]) }}">{{ $item->title }}</a>
                  </div>
                </div>
                <div class="meta mt-3">Dipublikasi oleh <span class="font-weight-600">{{ $item->author }}</span> pada
                  {{ $item->created_at->isoFormat('DD MMMM YYYY') }} | Dilihat <span class="font-weight-600">{{ $item->hit }}</span> kali</div>
              </div>
            </div>
          @endforeach
        </div>
        @if (isset($list) && $list->total() > $list->perPage())
          <div class="mt-md-5 d-flex justify-content-center mt-3">
            {{ $list->links() }}
          </div>
        @endif
      @else
        <x-pesan-tengah icon="mdi-bullhorn"
          title="Data Pengumuman Kosong" />
      @endif
    </div>
  </div>
@endsection
